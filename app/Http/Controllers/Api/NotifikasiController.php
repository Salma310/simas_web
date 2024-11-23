<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotifikasiController extends Controller
{
    public function index() {
        $notifikasi = Notification::all();
        return $notifikasi;
    }

    public function show(Request $request) {
        $notifikasi = Notification::all()->where('notification_id', $request->id)->first();
        return $notifikasi;
    }
}
