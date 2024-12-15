<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Notifications\EventNotification;
use Illuminate\Support\Facades\Notification;
// use App\Models\Notification;

class NotifikasiController extends Controller
{
    public function indexEvent() {
        $notification = Notification::all();
        $event = Event::all();
        return view('layouts.header', compact('event'));
    }

    public function indexPimpinan() {
        $notification = Notification::all();
        $event = Event::all();
        return view('layouts.header', compact('event'));
    }
}
