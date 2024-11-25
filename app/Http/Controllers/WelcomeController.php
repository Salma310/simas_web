<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $title = 'Dashboard';
        $activeMenu = 'dashboard';

        return view('welcome', ['title' => $title, 'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
