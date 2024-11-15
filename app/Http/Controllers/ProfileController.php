<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        // Static user data
    $user = [
        'nama' => 'Jason Price',
        'avatar' => 'default-avatar.jpeg',
        'level_nama' => 'Admin',
        'username' => '43527********',
        'nidn' => '43527********',
        'email' => 'jason.price@gmail.com',
        'no_hp' => '081336292772',
    ];

    // Define $activeMenu to highlight the correct menu in the layout
    $activeMenu = 'profile';

    // Send data to view
    return view('profile.index', compact('user', 'activeMenu'));
}

    public function updateAvatar(Request $request)
    {
        // Avatar update logic (placeholder)
        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updateDataDiri(Request $request)
    {
        // Profile data update logic (placeholder)
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        // Password update logic (placeholder)
        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}