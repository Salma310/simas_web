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
    // Validasi input
    $validator = Validator::make($request->all(), [
        'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->with('error', $validator->errors()->first());
    }

    // Dapatkan user yang sedang login
    $user = User::find(Auth::id());

    // Hapus gambar lama jika bukan default
    if ($user->picture && $user->picture != 'defaultUser.png') {
        Storage::delete('public/picture/' . $user->picture);
    }

    // Hash nama file baru
    $extension = $request->picture->extension();
    $pictureHash = hash('sha256', time() . $request->picture->getClientOriginalName()) . '.' . $extension;

    // Simpan file dengan nama hash
    $request->picture->storeAs('public/picture', $pictureHash);

    // Update database dengan nama file yang di-hash
    $user->picture = $pictureHash;
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
