<?php

namespace App\Http\Controllers\pimpinan;

use Illuminate\Http\Request;
use App\Models\EventType;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Position;
use App\Models\User;
use App\Models\Agenda;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EventpController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Event',
            'list' => ['Home', 'Event']
        ];

        $title = 'event';

        // Mengambil events dengan relasi agenda dan menghitung participants
        $events = Event::with(['agenda'])
            ->withCount('participants')
            ->get()
            ->map(function ($event) {
                // Hitung progress untuk setiap event
                $totalAgenda = $event->agenda->count();
                $completedAgenda = $event->agenda->where('status', 'completed')->count();

                // Hitung persentase progress
                $progressPercentage = $totalAgenda > 0
                    ? round(($completedAgenda / $totalAgenda) * 100, 2)
                    : 0;

                // Set status berdasarkan progress
                if ($progressPercentage === 0) {
                    $event->setAttribute('status', 'not started');
                } elseif ($progressPercentage < 100) {
                    $event->setAttribute('status', 'progress');
                } else {
                    $event->setAttribute('status', 'completed');
                }

                $event->save();

                return $event;
            });

        $jenisEvent = EventType::all();
        $jabatan = Position::all();
        $eventParticipant = EventParticipant::all();
        $user = User::all();
        $activeMenu = 'event pimpinan';

        return view('pimpinan.eventP.index', [
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'jenisEvent' => $jenisEvent,
            'jabatan' => $jabatan,
            'user' => $user,
            'eventParticipant' => $eventParticipant,
            'events' => $events
        ]);
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

    public function show_ajax(string $id)
    {
        $event = Event::with([
            'jenisEvent',
            'participants.position',
            'participants.user',
            'agenda' // Pastikan relasi agenda sudah didefinisikan di model Event
        ])->findOrFail($id);
        $jenisEvent = EventType::select('jenis_event_id', 'jenis_event_name')->get();
        $user = User::select('user_id', 'name', 'picture')->get();
        $jabatan = Position::select('jabatan_id', 'jabatan_name')->get();
        $agenda = Agenda::where('event_id', $id)->get();

        // Hitung progress
        $totalAgenda = $event->agenda->count();
        $completedAgenda = $event->agenda->where('status', 'completed')->count();

        // Hindari pembagian dengan nol
        $progressPercentage = $totalAgenda > 0
            ? round(($completedAgenda / $totalAgenda) * 100, 2)
            : 0;

        // Ambil data peserta (partisipan) dan jabatannya
        $eventParticipant = EventParticipant::where('event_id', $id)
            ->with(['user', 'position']) // Pastikan relasi `user` dan `position` ada di model
            ->get();

        return view('pimpinan.eventP.show', [
            'event' => $event,
            'jenisEvent' => $jenisEvent,
            'user' => $user,
            'jabatan' => $jabatan,
            'progressPercentage' => $progressPercentage,
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
        // Cek apakah request berasal dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            // Aturan validasi
            $rules = [
                'event_name' => 'required|string|max:100',
                'event_code' => "required|string|max:10|unique:m_event,event_code,'.$id.',event_id",
                'event_description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'jenis_event_id' => 'required|integer',
                'user_id' => 'required|array',
                'user_id.*' => 'required|integer|exists:m_user,user_id',
                'jabatan_id' => 'required|array',
                'jabatan_id.*' => 'required|integer|exists:m_jabatan,jabatan_id',
            ];

            // Validasi input
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            try {
                // Cari data event berdasarkan ID
                $event = Event::findOrFail($id);

                // Update data event
                $event->update([
                    'event_name' => $request->input('event_name'),
                    'event_code' => $request->input('event_code'),
                    'event_description' => $request->input('event_description'),
                    'start_date' => $request->input('start_date'),
                    'end_date' => $request->input('end_date'),
                    'jenis_event_id' => $request->input('jenis_event_id'),
                ]);

                // Hapus partisipan lama yang terkait dengan event
                EventParticipant::where('event_id', $event->event_id)->delete();

                // Tambahkan partisipan baru
                $userIds = $request->input('user_id');
                $jabatanIds = $request->input('jabatan_id');

                foreach ($userIds as $key => $userId) {
                    EventParticipant::updated([
                        'event_id' => $event->event_id,
                        'user_id' => $userId,
                        'jabatan_id' => $jabatanIds[$key] ?? null,
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data event dan partisipan berhasil diperbarui.',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ]);
            }
        }

        // Jika bukan request Ajax, redirect ke halaman lain
        return redirect('/');
    }


    public function confirm_ajax($id)
    {
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

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                // Hapus data peserta terkait di event_participants
                EventParticipant::where('event_id', $id)->delete();

                // Hapus data event dari tabel m_event
                $event = Event::find($id);
                if ($event) {
                    $event->delete(); // Hapus data event
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
        }
        return redirect('/');
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
