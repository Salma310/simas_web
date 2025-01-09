<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    //
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
         //set validation
        $validator = Validator :: make($request->all(), [
            'username' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required|min:5|confirmed',
            'role_id' => 'required',
            // 'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        //if validations fails
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        //create user
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        //return response JSON user is created
        if($user){
            return response()->json([
            'success' => true,
            'user' => $user,
            ], 201);
        }
        
        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
        // $user = UserModel::create($request->all());
        // return response()->json($user, 201);
    }

    public function show($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return $user;
        // return $user; // Mengembalikan data user yang ditemukan
        // return User::find($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return User::find($user);
    }

    public function updateProfile(Request $request, User $user)
    {
        Log::info('Starting updateProfile function for user ID: ' . $user->id);
        Log::info('Request Data: ' . json_encode($request->all()));


        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:15',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // maksimal 2MB
        ]);

        if ($validator->fails()) {
            Log::error('Validation errors: ', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Update data pengguna
            if ($request->has('username')) {
                $user->username = $request->input('username');
            }
            if ($request->has('email')) {
                $user->email = $request->input('email');
            }
            if ($request->has('phone')) {
                $user->phone = $request->input('phone');
            }

            // Update gambar profil jika ada
            if ($request->hasFile('picture')) {
                Log::info('Picture upload initiated for user ID: ' . $user->id);
                // Hapus gambar lama jika ada
                if ($user->picture) {
                    $oldPicturePath = 'public/profile_pictures/' . $user->picture;
                    // Storage::delete('public/profile_pictures/' . $user->picture);
                    Log::info('Deleting old picture: ' . $oldPicturePath);

                    if (Storage::exists($oldPicturePath)) {
                        Storage::delete($oldPicturePath);
                        Log::info('Old picture deleted successfully.');
                    } else {
                        Log::warning('Old picture not found: ' . $oldPicturePath);
                    }
                }

                // Simpan gambar baru
                $file = $request->file('picture');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('public/profile_pictures', $fileName);

                Log::info('New picture saved: ' . $filePath);
                // Simpan nama file di database
                $user->picture = $fileName;
            }

            // Simpan perubahan
            $user->save();
            Log::info('User profile updated successfully for user ID: ' . $user->id);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $user,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updatePicture(Request $request, $userId)
    {

         // Ambil data pengguna berdasarkan user_id yang diberikan
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Validasi file gambar
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Hapus foto lama jika ada
            if ($user->picture) {
                Storage::delete($user->picture);
            }

            // Simpan gambar baru
            $filePath = $request->file('picture')->store('profile_pictures');

            // Perbarui data user
            $user->update([
                'picture' => $filePath,
            ]);

            return response()->json([
                'message' => 'Profile picture updated successfully!',
                'picture_url' => Storage::url($filePath),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update profile picture.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function changePassword(Request $request, $user)
    {
        Log::info('[ChangePassword] Password change process started for user ID: ' . auth()->id());

        // $user = auth()->user(); // Mengambil user yang sedang login
        // $user = \App\Models\User::find(auth()->id());
        $user = \App\Models\User::find($user);
        
        if (!$user) {
            Log::warning("[ChangePassword] User not found for ID: $user");

            return response()->json(['message' => 'User not found'], 404);
        }
        // Validasi input
        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:5', // Atur panjang minimal password
        ]);
        Log::info('[ChangePassword] Input validation passed');


        // Cek apakah old_password cocok dengan yang ada di database
        if (!Hash::check($validated['old_password'], $user->password)) {
            Log::warning('[ChangePassword] Old password mismatch for user ID: ' . $user->id);

            return response()->json(['message' => 'Old password is incorrect'], 400);
        }

        // Update password
        Log::info('[ChangePassword] Old password verified for user ID: ' . $user->id);

        $user->password = Hash::make($validated['new_password']);
        $user->save();
        Log::info('[ChangePassword] Password updated successfully for user ID: ' . $user->id);


        // Return response sukses
        return response()->json(['message' => 'Password updated successfully']);
    }

    // public function changePassword(Request $request)
    // {
    //     $user = auth()->user(); // Dapatkan user yang sedang login

    //     // Validasi input
    //     $request->validate([
    //         'old_password' => 'required',
    //         'new_password' => 'required|min:6|confirmed',
    //     ]);

    //     // Cek apakah password lama cocok
    //     if (!Hash::check($request->old_password, $user->password)) {
    //         return response()->json(['message' => 'Password lama salah'], 400);
    //     }

    //     // Update password
    //     $user->password = bcrypt($request->new_password);
    //     $user->save();

    //     return response()->json(['message' => 'Password berhasil diubah'], 200);
    // }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
