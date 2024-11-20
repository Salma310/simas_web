<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Position;
use App\Models\User;
use App\Models\Agenda;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Event']
        ];

        $jenisEvent = EventType::all();
        $jabatan = Position::all();
        $user = User::all();
        $eventParticipant = EventParticipant::all();
        $activeMenu = 'event';

        return view('event.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'jenisEvent' => $jenisEvent, 'jabatan' => $jabatan, 'user' => $user, 'eventParticipant' => $eventParticipant]);
    }

    public function list(Request $request)
    {
        $event = Event::select('event_id', 'event_name', 'event_code', 'event_description', 'start_date', 'end_date', 'status', 'assign_letter', 'jenis_event_id')
            ->with(['jenisEvent', 'eventParticipant']);

        return DataTables::of($event)
            ->addIndexColumn()
            ->addColumn('participant_name', function ($event) {
                $participant = $event->eventParticipant->firstWhere('jabatan_id', 1);
                return $participant ? $participant->user->name : '-';
            })
            ->addColumn('aksi', function ($event) {
                $btn = '<div class="btn-group" role="group" aria-label="Basic example"> <button onclick="modalAction(\'' . url('/event/' . $event->event_id . '/show_ajax') . '\')" class="btn btn-light"><i class="fas fa-qrcode"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/event/' . $event->event_id . '/edit_ajax') . '\')" class="btn btn-light"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/event/' . $event->event_id . '/delete_ajax') . '\')" class="btn btn-light"><i class="fas fa-trash"></i></button></div>';
                return $btn;
            })
            ->rawColumns(['aksi']) // ada teks html
            ->make(true);
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

        $jenisEvent = EventType::all();
        $jabatan = Position::all();
        $user = User::all();
        $eventParticipant = EventParticipant::all();
        $activeMenu = 'event'; // set menu yang sedang aktif

        return view('event.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'jenisEvent' => $jenisEvent, 'jabatan' => $jabatan, 'user' => $user, 'eventParticipant' => $eventParticipant, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $jenisEvent = EventType::select('jenis_event_id', 'jenis_event_name')->get();
        $user = User::select('user_id', 'name')->get();
        $jabatan = Position::select('jabatan_id', 'jabatan_name')->get();
        return view('event.create_ajax')
            ->with('jenisEvent', $jenisEvent)
            ->with('user', $user)
            ->with('jabatan', $jabatan);
    }

    public function store_ajax(Request $request)
    {
        // Cek apakah request berupa ajax atau ingin JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'event_name' => 'required|string|max:100',
                'event_code' => 'required|string|max:10|unique:m_event,event_code',
                'event_description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'jenis_event_id' => 'required|integer',
                // Validasi untuk array user_id dan jabatan_id
                'user_id' => 'required|array',
                'user_id.*' => 'required|integer|exists:m_user,user_id',
                'jabatan_id' => 'required|array',
                'jabatan_id.*' => 'required|integer|exists:m_jabatan,jabatan_id',
            ];
    
            // Gunakan Validator untuk memvalidasi data
            $validator = Validator::make($request->all(), $rules);
    
            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
    
            try {
                // Simpan data event
                $event = Event::create([
                    'event_name' => $request->input('event_name'),
                    'event_code' => $request->input('event_code'),
                    'event_description' => $request->input('event_description'),
                    'start_date' => $request->input('start_date'),
                    'end_date' => $request->input('end_date'),
                    'jenis_event_id' => $request->input('jenis_event_id'),
                    'status' => 'not started', // Tambahkan status default
                ]);
    
                // Simpan data ke event_participants untuk setiap kombinasi user_id dan jabatan_id
                $userIds = $request->input('user_id');
                $jabatanIds = $request->input('jabatan_id');
    
                foreach ($userIds as $key => $userId) {
                    EventParticipant::create([
                        'event_id' => $event->event_id, // Ambil ID dari event yang baru disimpan
                        'user_id' => $userId,
                        'jabatan_id' => $jabatanIds[$key] ?? null, // Pastikan indeks cocok
                    ]);
                }
    
                // Jika berhasil
                return response()->json([
                    'status' => true,
                    'message' => 'Data event berhasil disimpan',
                ]);
    
            } catch (\Exception $e) {
                // Jika terjadi kesalahan pada proses simpan
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ]);
            }
        }
    
        // Redirect jika bukan request Ajax
        return redirect('/');
    }

    public function show_ajax(string $id) {
        $event = Event::find($id);
         $jenisEvent = EventType::select('jenis_event_id', 'jenis_event_name')->get();
         $user = User::select('user_id', 'name')->get();
         $jabatan = Position::select('jabatan_id', 'jabatan_name')->get();
         $agenda = Agenda::where('event_id', $id)->get();
         
         // Ambil data peserta (partisipan) dan jabatannya
         $eventParticipant = EventParticipant::where('event_id', $id)
             ->with(['user', 'position']) // Pastikan relasi `user` dan `position` ada di model
             ->get();
     
         return view('event.detail_ajax', [
             'event' => $event,
             'jenisEvent' => $jenisEvent,
             'user' => $user,
             'jabatan' => $jabatan,
             'agenda' => $agenda,
             'eventParticipant' => $eventParticipant
         ]);
     }

     public function edit_ajax($id)
     {
         $event = Event::find($id);
         $jenisEvent = EventType::select('jenis_event_id', 'jenis_event_name')->get();
         $user = User::select('user_id', 'name')->get();
         $jabatan = Position::select('jabatan_id', 'jabatan_name')->get();
         
         // Ambil data peserta (partisipan) dan jabatannya
         $eventParticipant = EventParticipant::where('event_id', $id)
             ->with(['user', 'position']) // Pastikan relasi `user` dan `position` ada di model
             ->get();
     
         return view('event.edit_ajax', [
             'event' => $event,
             'jenisEvent' => $jenisEvent,
             'user' => $user,
             'jabatan' => $jabatan,
             'eventParticipant' => $eventParticipant
         ]);
     }
     

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'event_name' => 'required|string|max:100',
                'event_code' => 'required|string|max:10|unique:m_event,event_code',
                'event_description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'jenis_event_id' => 'required|integer',
                // Validasi untuk array user_id dan jabatan_id
                'user_id' => 'required|array',
                'user_id.*' => 'required|integer|exists:m_user,user_id',
                'jabatan_id' => 'required|array',
                'jabatan_id.*' => 'required|integer|exists:m_jabatan,jabatan_id',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = Event::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax($id) {
        $event = Event::find($id);
         $jenisEvent = EventType::select('jenis_event_id', 'jenis_event_name')->get();
         $user = User::select('user_id', 'name')->get();
         $jabatan = Position::select('jabatan_id', 'jabatan_name')->get();
         
         // Ambil data peserta (partisipan) dan jabatannya
         $eventParticipant = EventParticipant::where('event_id', $id)
             ->with(['user', 'position']) // Pastikan relasi `user` dan `position` ada di model
             ->get();
     
         return view('event.confirm_ajax', [
             'event' => $event,
             'jenisEvent' => $jenisEvent,
             'user' => $user,
             'jabatan' => $jabatan,
             'eventParticipant' => $eventParticipant
         ]);
    }

    //BUAT NON-JTI
    public function indexNonJTI()
    {
        $events = Event::where('category', 'Non-JTI')->get();
        return view('events.non_jti.index', compact('events'));
    }

    public function createNonJTI()
    {
        return view('events.non_jti.create');
    }

    public function storeNonJTI(Request $request)
    {
        $request->validate([
            'event_name' => 'required|min:3|max:100',
            'event_code' => 'required|min:3|max:10|unique:events,event_code',
            'pic' => 'required|min:3|max:100',
            'event_date' => 'required|date',
            'event_description' => 'required|min:5',
            'assignment_letter' => 'required|file|mimes:jpg,png,pdf|max:10240',
        ]);

        // Simpan data ke database
        $event = new Event();
        $event->event_name = $request->event_name;
        $event->event_code = $request->event_code;
        $event->pic = $request->pic;
        $event->start_date = $request->event_date;
        $event->event_description = $request->event_description;

        if ($request->hasFile('assignment_letter')) {
            $path = $request->file('assignment_letter')->store('assignment_letters');
            $event->assignment_letter = $path;
        }

        $event->category = 'Non-JTI';
        $event->save();

        return response()->json([
            'status' => true,
            'message' => 'Event Non-JTI berhasil ditambahkan!',
        ]);
    }

    public function editNonJTI($id)
    {
        $event = Event::findOrFail($id);
        return view('events.non_jti.edit', compact('event'));
    }

    public function updateNonJTI(Request $request, $id)
    {
        $request->validate([
            'event_name' => 'required|min:3|max:100',
            'event_code' => 'required|min:3|max:10|unique:events,event_code,' . $id,
            'pic' => 'required|min:3|max:100',
            'event_date' => 'required|date',
            'event_description' => 'required|min:5',
            'assignment_letter' => 'nullable|file|mimes:jpg,png,pdf|max:10240',
        ]);

        $event = Event::findOrFail($id);
        $event->event_name = $request->event_name;
        $event->event_code = $request->event_code;
        $event->pic = $request->pic;
        $event->start_date = $request->event_date;
        $event->event_description = $request->event_description;

        if ($request->hasFile('assignment_letter')) {
            $path = $request->file('assignment_letter')->store('assignment_letters');
            $event->assignment_letter = $path;
        }

        $event->save();

        return response()->json([
            'status' => true,
            'message' => 'Event Non-JTI berhasil diperbarui!',
        ]);
    }
}