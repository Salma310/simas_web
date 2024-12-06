<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Cek user berdasarkan username atau email
        $user = User::where('username', $request->username)
            // ->orWhere('email', $request->username)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        // Generate token
        $token = auth()->guard('api')->login($user);
        $user->auth_token = $token;
        $user->save();

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ], 200)->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }

    // public function __invoke(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'username' => 'required',
    //         'password' => 'required'
    //     ]);

    //     if($validator->fails()){
    //         return response()->json($validator->errors(), 422);
    //     }

    //     //get credentials from request
    //     $credentials = $request->only('username', 'password');

    //     //if auth failed
    //     if(!$token = auth()->guard('api')->attempt($credentials)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Username atau Password Anda salah'
    //         ], 401);
    //     }

    //     //if auth success
    //     return response()->json([
    //         'success' => true,
    //         'user' => auth()->guard('api')->user(),
    //         'token' => $token
    //     ], 200);
    // }

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
