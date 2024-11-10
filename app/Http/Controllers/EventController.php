<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){

        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'event';

        return view('event.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
