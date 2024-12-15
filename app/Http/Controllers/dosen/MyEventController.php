<?php

namespace App\Http\Controllers\dosen;


use App\Models\Event;
use App\Models\Agenda;
use App\Models\Position;
use App\Models\EventType;
use Illuminate\Http\Request;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class MyEventController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $title = 'My Event';
        $user = Auth::user(); // Get the currently logged-in user

        // Fetch events that the current user has participated in
        $events = Event::whereHas('participants', function($query) use ($user) {
            $query->where('user_id', $user->user_id);
        })->withCount('participants')->get();

        $jenisEvent = EventType::all();
        $activeMenu = 'myevent';

        return view('dosen.myEvent.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'title' => $title,
            'jenisEvent' => $jenisEvent,
            'events' => $events
        ]);
    }

    //BUAT NON-JTI
    // public function indexNonJTI()
    // {
    //     $events = Event::where('category', 'Non-JTI')->get();
    //     return view('dosen.myEvent.non_jti.index', compact('dosen.myEvent'));
    // }

    public function createNonJTI()
    {
        $jenisEvent = EventType::all();
        $jabatan = Position::all();
        $currentUser = Auth::user(); // Get the currently authenticated user

        return view('dosen.myEvent.non_jti.create', [
            'jenisEvent' => $jenisEvent,
            'jabatan' => $jabatan,
            'user' => $currentUser ? [$currentUser] : [] // Pass current user in an array, or empty array if not logged in
        ]);
    }

    public function storeNonJTI(Request $request)
    {
        // Validation rules
        $rules = [
            'event_name' => 'required|string|max:100',
            'event_code' => 'required|string|max:10|unique:m_event,event_code',
            'event_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'jenis_event_id' => 'required|integer',
            'participant' => 'required|array|min:1',
            'participant.*.user_id' => 'required|integer|exists:m_user,user_id',
            'participant.*.jabatan_id' => 'required|integer|exists:m_jabatan,jabatan_id',
        ];

        // Validate request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Create event
            $event = Event::create([
                'event_name' => $request->event_name,
                'event_code' => $request->event_code,
                'event_description' => $request->event_description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'jenis_event_id' => $request->jenis_event_id,
                'status' => 'not started',
            ]);

            // Create event participants
            foreach ($request->participant as $participant) {
                EventParticipant::create([
                    'event_id' => $event->event_id,
                    'user_id' => $participant['user_id'],
                    'jabatan_id' => $participant['jabatan_id']
                ]);
            }

            DB::commit();

            return redirect()->route('event.index')
                ->with('success', 'Event berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show_ajax(string $id)
    {
        $title = 'Detail Event';
        $activeMenu = 'myevent';

        // Load event dengan agenda
        $event = Event::with([
            'jenisEvent',
            'participants.position',
            'participants.user',
            'agenda' // Pastikan relasi agenda sudah didefinisikan di model Event
        ])->findOrFail($id);

        // Hitung progress
        $totalAgenda = $event->agenda->count();
        $completedAgenda = $event->agenda->where('status', 'done')->count();

        // Hindari pembagian dengan nol
        $progressPercentage = $totalAgenda > 0
            ? round(($completedAgenda / $totalAgenda) * 100, 2)
            : 0;

        $user = Auth::user();
        $jabatan = Position::select('jabatan_id', 'jabatan_name')->get();

        $eventParticipant = EventParticipant::where('user_id', $user->user_id)
            ->with(['user', 'position'])
            ->get();

        return view('dosen.myEvent.show', [
            'event' => $event,
            'user' => $user,
            'jabatan' => $jabatan,
            'eventParticipant' => (bool)$eventParticipant,
            'progressPercentage' => $progressPercentage, // Tambahkan progress ke view
            'title' => $title,
            'activeMenu' => $activeMenu
        ]);
    }

    public function agendaAGT($id = null){
        $event = null;
        if ($id) {
            $event = Event::findOrFail($id);
            $agendas = Agenda::where('event_id', $id)->get();
        } else {
            $agendas = Agenda::all();
        }

        $title = 'List Agenda';
        $activeMenu = 'myevent';

        return view('dosen.myevent.agendaAGT.index', compact('agendas', 'event', 'title', 'activeMenu'));
    }

    public function agendaPIC($id = null) {
        $event = null;
        if ($id) {
            $event = Event::findOrFail($id);
            $agendas = Agenda::where('event_id', $id)->get();
        } else {
            $agendas = Agenda::all();
        }

        $title = 'List Agenda';
        $activeMenu = 'event dosen';

        return view('dosen.myEvent.agendaPIC.index', compact('agendas', 'event', 'title', 'activeMenu'));
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
