<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JenisEventController extends Controller
{
    public function index(){

        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'jenis event';

        return view('jenis.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
