<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Profil;

class ProfilController extends Controller
{
    public function index()
{
    // Dapatkan profil dari model atau contoh data (tidak terkait dengan pengguna yang login)
    $profil = User::first(); // Misalnya mengambil profil pertama

    // Jika profil terkait dengan user tertentu, bisa diatur seperti ini
    // $profil = Profil::where('user_id', 1)->first(); // Sesuaikan ID-nya

    // Tampilkan halaman profil
    return view('profile.index', compact('profil'));
}


    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        // Hapus avatar lama jika ada
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        // Simpan avatar baru
        $avatarPath = $request->file('avatar')->store('public/avatars');
        $user->avatar = basename($avatarPath);
        $user->save();

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updateDataDiri(Request $request)
    {
        $request->validate([
            'no_hp' => 'nullable|string|max:15',
        ]);

        $user = Auth::user();
        $profil = $user->profil;

        // Jika profil belum ada, buat profil baru
        if (!$profil) {
            $profil = new Profil();
            $profil->user_id = $user->id;
        }

        // Update nomor telepon
        $profil->no_hp = $request->no_hp;
        $profil->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Cek apakah password lama cocok
        if (!Hash::check($request->old_password, $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => 'Password lama salah.',
            ]);
        }

        // Update password baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}
