<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;


class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                // Format tanggal hari ini
                $today = now()->format('d-m-Y');

                // Tambah jumlah login untuk hari ini di cache
                $logins = Cache::get('daily_logins', []);
                $logins[$today] = isset($logins[$today]) ? $logins[$today] + 1 : 1;
                Cache::put('daily_logins', $logins, now()->addDays(7));


                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/dashboard')
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }
        return redirect('/');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showForgot()
    {
        return view('auth.forgot');
    }

    public function forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:m_user',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Password berhasil direset. Silakan login dengan password baru',
                'redirect' => url('/')
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Password tidak dapat diganti',
        ]);
    }
}
