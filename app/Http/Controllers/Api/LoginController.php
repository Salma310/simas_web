<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::info('Login request received', $request->all());
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Cek user berdasarkan username atau email
        $user = User::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (!$user) {
            Log::error('User not found', ['username' => $request->username]);
            return response()->json([
                // var_dump($user),
                // die();
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            Log::error('Invalid credentials', ['username' => $request->username]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Generate token
        $token = auth()->guard('api')->login($user);
        Log::info('User logged in', ['username' => $user->username]);


        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $user->user_id,
                'username' => $user->username,
                // 'email' => $user->email,
                'role_id' => $user->role->role_id, // Asumsikan role relasi sudah diatur
            ],
            'token' => $token,
        ], 200)->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    public function getUser(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Cek jika user ada
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'user' => $user], 200);
    }
}
