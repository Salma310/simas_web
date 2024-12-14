<?php

namespace App\Http\Controllers\dosen;

use App\Models\Agenda;
use Illuminate\Http\Request;
use App\Models\EventType;
use App\Models\Event;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class MyEventController extends Controller
{
    public function index(){

        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $title = 'My Event';
        $events = Event::withCount('participants')->get();
        $jenisEvent = EventType::all();
        $activeMenu = 'My Event';

        return view('dosen.myEvent.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'title' => $title, 'jenisEvent' => $jenisEvent, 'events' => $events]);
    }

    //BUAT NON-JTI
    // public function indexNonJTI()
    // {
    //     $events = Event::where('category', 'Non-JTI')->get();
    //     return view('dosen.myEvent.non_jti.index', compact('dosen.myEvent'));
    // }

    public function createNonJTI()
    {
        return view('dosen.myEvent.non_jti.create');
    }

    public function storeNonJTI(Request $request)
    {
        $request->validate([
            'event_name' => 'required|min:3|max:100',
            'jenis_event_id' => 'required|integer',
            'event_code' => 'required|min:3|max:10|unique:m_event,event_code',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'event_description' => 'required|min:5',
            'assign_letter' => 'required|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        // Simpan data ke database
        $event = new Event();
        $event->event_name = $request->event_name;
        $event->jenis_event_id = $request->jenis_event_id;
        $event->event_code = $request->event_code;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;     
        $event->event_description = $request->event_description;

        if ($request->hasFile('assign_letter')) {
            $path = $request->file('assign_letter')->store('public/surat_tugas');
            $event->assign_letter = $path;
        }

        $event->save();

        return response()->json([
            'status' => true,
            'message' => 'Event Non-JTI berhasil ditambahkan!',
        ]);
    }

    public function editNonJTI($id)
    {
        $event = Event::findOrFail($id);
        return view('dosen.myEvent.non_jti.edit', compact('dosen.myEvent'));
    }

    public function updateNonJTI(Request $request, $id)
    {
        $request->validate([
            'event_name' => 'required|min:3|max:100',
            'jenis_event_id' => 'required|integer',
            'event_code' => 'required|min:3|max:10|unique:m_event,event_code',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'event_description' => 'required|min:5',
            'assign_letter' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $event = Event::findOrFail($id);
        $event->event_name = $request->event_name;
        $event->jenis_event_id = $request->jenis_event_id;
        $event->event_code = $request->event_code;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;  
        $event->event_description = $request->event_description;

        if ($request->hasFile('assign_letter')) {
            $path = $request->file('assign_letter')->store('public/surat_tugas');
            $event->assign_letter = $path;
        }

        $event->save();

        return response()->json([
            'status' => true,
            'message' => 'Event Non-JTI berhasil diperbarui!',
        ]);
    }
}