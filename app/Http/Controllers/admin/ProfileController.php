<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile()
    {
        $title = 'Profile';
        $user = User::find(Auth::id());// Mendapatkan user yang sedang login
        $activeMenu = 'profile';

        return view('profile.index', compact('title', 'user', 'activeMenu'));
    }

    public function updatePicture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user = User::find(Auth::id());

        // Hapus picture lama jika bukan default
        if ($user->picture && $user->picture != 'defaultUser.png') {
            Storage::delete('public/picture/' . $user->picture);
        }

        // Simpan picture baru
        $pictureName = time() . '.' . $request->picture->extension();
        $request->picture->storeAs('public/picture', $pictureName);

        // Update picture di database
        $user->picture = $pictureName;
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updateDataDiri(Request $request)
    {
        $user = User::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:15',
            'email' => 'required|string',// Validasi email
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user->phone = $request->phone;
        $user->email = $request->email; // Simpan email baru
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $user = User::find(Auth::id());

        // Periksa password lama
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai.');
        }

        // Update password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}
