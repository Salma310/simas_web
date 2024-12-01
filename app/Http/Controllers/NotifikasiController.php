<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotifikasiController extends Controller
{
    public function index() {
        $notifikasi = Notification::all();
        return view('notifikasi', ['notifikasi' => $notifikasi]);
    }
}
