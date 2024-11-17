<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Position;
use App\Models\User;
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
        return redirect('/event');
    }
}
