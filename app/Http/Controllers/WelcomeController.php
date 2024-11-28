<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $event = Event::all();
        $user = User::all();
        $title = 'Dashboard';
        $activeMenu = 'dashboard';

        return view('welcome', ['title' => $title, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'event' => $event, 'user' => $user]);
    }
}
