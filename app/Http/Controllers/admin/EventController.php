<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\EventType;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Agenda;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'Event',
            'list' => ['Home', 'Event']
        ];

        $title = 'event';
        $jenisEvent = EventType::all();
        $jabatan = Position::all();
        $user = User::all();
        $eventParticipant = EventParticipant::all();
        $activeMenu = 'event';

        return view('admin.event.index', [ 'title' => $title,'breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'jenisEvent' => $jenisEvent, 'jabatan' => $jabatan, 'user' => $user, 'eventParticipant' => $eventParticipant]);
    }

    public function list(Request $request)
    {
        $event = Event::select('event_id', 'event_name', 'event_code', 'event_description', 'start_date', 'end_date', 'status', 'assign_letter', 'jenis_event_id', 'point')
            ->with(['jenisEvent', 'participants']);

        return DataTables::of($event)
            ->addIndexColumn()
            ->addColumn('participant_name', function ($event) {
                $participant = $event->participants->firstWhere('jabatan_id', 1);
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

    public function create_ajax()
    {
        $jenisEvent = EventType::select('jenis_event_id', 'jenis_event_name')->get();
        $user = User::select('user_id', 'name')->get();
        $jabatan = Position::select('jabatan_id', 'jabatan_name')->get();
        return view('admin.event.create_ajax')
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
                'point' => 'required|numeric|min:0',
                // Validasi untuk array user_id dan jabatan_id
                'participant' => 'required|array|min:1',
                'participant.*.user_id' => 'required|integer|exists:m_user,user_id',
                'participant.*.jabatan_id' => 'required|integer|exists:m_jabatan,jabatan_id',
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
                    'point' => $request->input('point'),
                ]);

                // Simpan data ke event_participants untuk setiap kombinasi user_id dan jabatan_id

                foreach ($request->participant as $participants) {
                    EventParticipant::create([
                        'event_id' => $event->event_id, // Ambil ID dari event yang baru disimpan
                        'user_id' => $participants['user_id'],
                        'jabatan_id' => $participants['jabatan_id']
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

         return view('admin.event.detail_ajax', [
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

         return view('admin.event.edit_ajax', [
             'event' => $event,
             'jenisEvent' => $jenisEvent,
             'user' => $user,
             'jabatan' => $jabatan,
             'eventParticipant' => $eventParticipant
         ]);
     }


     public function update_ajax(Request $request, $id)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'event_name' => 'required|string|max:100',
            'event_code' => 'required|string|max:10|unique:m_event,event_code,'. $id . ',event_id',
            'event_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'jenis_event_id' => 'required|integer',
            'point' => 'required|numeric|min:0',
            'participant' => 'required|array|min:1',
            'participant.*.user_id' => 'required|integer|exists:m_user,user_id',
            'participant.*.jabatan_id' => 'required|integer|exists:m_jabatan,jabatan_id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $event = Event::findOrFail($id);

            // Update event details
            $event->update([
                'event_name' => $request->event_name,
                'event_code' => $request->event_code,
                'event_description' => $request->event_description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'jenis_event_id' => $request->jenis_event_id,
                'point' => $request->point,
            ]);

            // Delete existing participants
            EventParticipant::where('event_id', $id)->delete();

            // Add new participants
            $participantA = [];
            foreach ($request->participant as $participants) {
                $participantA[] = [
                    'event_id' => $event->event_id,
                    'jabatan_id' => $participants['jabatan_id'],
                    'user_id' => $participants['user_id'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            EventParticipant::insert($participantA);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    return response()->json([
        'status' => false,
        'message' => 'Invalid request method'
    ], 400);
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

         return view('admin.event.confirm_ajax', [
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
            // Delete event participants
            EventParticipant::where('event_id', $id)->delete();

            // Delete event
            $event = Event::find($id);
            if ($event) {
                $event->delete();
                return response()->json(['status' => true, 'message' => 'Data deleted successfully']);
            } else {
                return response()->json(['status' => false, 'message' => 'Data not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    return redirect('/');
}
}
