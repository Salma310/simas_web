<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Cache;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        // Ambil data login dari cache
        $logins = Cache::get('daily_logins', []);

        // Pastikan urutkan data berdasarkan tanggal
        ksort($logins);

        $event = Event::all();
        $user = User::all();
        $role = Role::all();
        $title = 'Dashboard';
        $activeMenu = 'dashboard';

        return view('welcome', ['title' => $title, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'event' => $event, 'user' => $user, 'role' => $role, 'dailyLogins' => $logins]);
    }
}
