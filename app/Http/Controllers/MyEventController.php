<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use App\Models\EventType;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class MyEventController extends Controller
{
    public function index(){

        $title = 'My Event';
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'My Event';

        return view('my_event.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'title' => $title]);
    }

    public function agenda(){

        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'My Event';

        return view('agenda.table', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function agenda_list(Request $request)
    {
        $agenda = Agenda::select('event_id', 'nama_agenda', 'waktu', 'tempat', 'point_beban_kerja')
            ->with(['event']);

        return DataTables::of($agenda)
            ->addIndexColumn()
            // ->addColumn('nama_agenda', function ($agenda) {
            //     // $participant = $event->eventParticipant->firstWhere('jabatan_id', 1);
            //     return $participant ? $participant->user->name : '-';
            // })
            ->addColumn('aksi', function ($event) {
                $btn = '<div class="btn-group" role="group" aria-label="Basic example"> <button onclick="modalAction(\'' . url('/myevent/' . $event->event_id . '/show_agenda') . '\')" class="btn btn-light"><i class="fas fa-qrcode"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/myevent/' . $event->event_id . '/edit_agenda') . '\')" class="btn btn-light"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/myevent/' . $event->event_id . '/delete_agenda') . '\')" class="btn btn-light"><i class="fas fa-trash"></i></button></div>';
                return $btn;
            })
            ->rawColumns(['aksi']) // ada teks html
            ->make(true);
    }
}
