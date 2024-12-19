<?php

namespace App\Http\Controllers\dosen;

use App\Models\User;
use App\Models\Event;
use App\Models\Agenda;
use App\Models\Position;
use App\Models\EventType;
use Illuminate\Http\Request;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EventdController extends Controller
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
                    $event->status = 'not started';
                } elseif ($progressPercentage < 100) {
                    $event->status = 'progress';
                } else {
                    $event->status = 'completed';
                }

                $event->save();

                return $event;
            });

        $jenisEvent = EventType::all();
        $jabatan = Position::all();
        $eventParticipant = EventParticipant::all();
        $user = User::all();
        $activeMenu = 'event dosen';

        return view('dosen.event.index', [
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
        $title = 'Detail Event';
        $activeMenu = 'event dosen';

        // Load event dengan agenda
        $event = Event::with([
            'jenisEvent',
            'participants.position',
            'participants.user',
            'agenda' // Pastikan relasi agenda sudah didefinisikan di model Event
        ])->findOrFail($id);

        // Hitung progress
        $totalAgenda = $event->agenda->count();
        $completedAgenda = $event->agenda->where('status', 'completed')->count();

        // Hindari pembagian dengan nol
        $progressPercentage = $totalAgenda > 0
            ? round(($completedAgenda / $totalAgenda) * 100, 2)
            : 0;

        $user = Auth::user();
        $jabatan = Position::select('jabatan_id', 'jabatan_name')->get();

        $eventParticipant = EventParticipant::where('user_id', $user->user_id)
            ->with(['user', 'position'])
            ->get();

        return view('dosen.event.show', [
            'event' => $event,
            'user' => $user,
            'jabatan' => $jabatan,
            'eventParticipant' => (bool)$eventParticipant,
            'progressPercentage' => $progressPercentage, // Tambahkan progress ke view
            'title' => $title,
            'activeMenu' => $activeMenu
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
}
