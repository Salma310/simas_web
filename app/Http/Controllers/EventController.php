<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;

class EventController extends Controller
{
    public function index(){

        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Event']
        ];

        $activeMenu = 'event';

        return view('event.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Event',
            'list' => ['Home', 'Event', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah event baru'
        ];

        $jenisEvent = EventType::all(); //ambil data level untuk ditampilkan di form
        $activeMenu = 'event'; // set menu yang sedang aktif

        return view('event.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'jenisEvent' => $jenisEvent, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
     {
         $jenisEvent = EventType::select('jenis_event_id', 'jenis_event_nama')->get();
         return view('event.create_ajax')
             ->with('jenisEvent', $jenisEvent);
     }
}
