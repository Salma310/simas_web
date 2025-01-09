<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Agenda;
use App\Models\EventType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $searchQry = $request->searchQry;
        $status = $request->status;
        $eventTypeId = $request->eventTypeId;
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $eventsQry = Event::all();
        // $events = Event::where('column_name', 'LIKE', '%' . $searchQry . '%')->get();
        // $events = EventModel::all();
        $eventsQry = Event::with(['jenisEvent', 'participants.user', 'participants.position']);
        if ($searchQry  && $searchQry != '') {
            $eventsQry->where('event_name', 'LIKE', '%' . $searchQry . '%');
        }

        if ($status && $status != '') {
            $eventsQry->where('status', $status);
        }
        if ($eventTypeId && $eventTypeId != 0 && $eventTypeId != '0') {
            $eventsQry->where('jenis_event_id', $eventTypeId);
        }
        if ($startDate && $startDate != '') {
            $eventsQry->where('start_date', '>=', $startDate);
        }
        if ($endDate && $endDate != '') {
            $eventsQry->where('end_date', '<=', $endDate);
        }
        $events = $eventsQry->get();

        if ($events->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No events found',
                'data' => [],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $events,
        ]);
        // $events = Event::all(); // Mengambil semua data dari tabel m_event
        // return response()->json($events); // Mengembalikan data dalam format JSON
    }

    public function updateStatus($id, Request $request)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:completed,in-progress,not-started'
        ]);

        try {
            // Cari agenda berdasarkan ID
            $agenda = Agenda::findOrFail($id);

            // Update status agenda
            $agenda->status = $request->status;
            $agenda->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Agenda status updated successfully.',
                'data' => $agenda
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }
    public function eventType()
    {

        $events = EventType::all();


        if ($events->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No events found',
                'data' => [],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $events,
        ]);
    }

    public function getUserEvents(Request $request, $user_id)
    {
    // Ambil parameter dari request
    // $user_id = $request->userId; // Parameter userId dari API
    $eventTypeId = $request->eventTypeId; // Parameter eventTypeId dari API

    Log::info("getUserEvents called with user_id: $user_id, eventTypeId: $eventTypeId");

    // Validasi user_id terlebih dahulu
    if (!$user_id) {
        Log::error("Validation failed: User ID is missing");

        return response()->json([
            'success' => false,
            'message' => 'User ID is required',
            'data' => []
        ], 400);
    }

    try {
        // Ambil semua event yang diikuti oleh user berdasarkan user_id
        $eventIds = EventParticipant::where('user_id', $user_id)
            ->pluck('event_id'); // Mengambil hanya event_id

            Log::info("Event IDs for user_id $user_id: ", $eventIds->toArray());

        // Query event berdasarkan event_id
        $eventsQry = Event::whereIn('event_id', $eventIds);

        // Tambahkan filter berdasarkan jenis_event_id jika tersedia
        if ($eventTypeId && $eventTypeId != 0) {
            Log::info("Filtering events with jenis_event_id: $eventTypeId");

            $eventsQry->where('jenis_event_id', $eventTypeId);
        }

        // Load relasi jenisEvent dan participants jika ada
        $events = $eventsQry->with(['jenisEvent', 'participants.user', 'participants.position'])->get();
        Log::info("Fetched events count: " . $events->count());


        // Periksa jika data kosong
        if ($events->isEmpty()) {
            Log::info("No events found for user_id $user_id");

            return response()->json([
                'success' => true,
                'message' => 'No events found',
                'data' => []
            ]);
        }

        // Kembalikan data JSON jika berhasil
        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    } catch (\Exception $e) {
        Log::error("Exception occurred: " . $e->getMessage());

        // Tangani error jika terjadi
        return response()->json([
            'success' => false,
            'message' => 'An error occurred: ' . $e->getMessage(),
            'data' => []
        ], 500);
    }
}


    public function showAgenda($eventId)
    {
        try {
            // Fetch the agendas for the specified event ID
            $agendas = Agenda::with(['assignees.user', 'assignees.position', 'documents'])
                ->where('event_id', $eventId)
                ->get();
            Log::info('Agendas fetched: ', $agendas->toArray());

            // Check if agendas exist for the event
            if ($agendas->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No agendas found for this event.'
                ], 404);
            }

            // Format the response
            // $formattedAgendas = $agendas->map(function ($agenda) {
            //     return [
            //         'agenda_id' => $agenda->agenda_id,
            //         'nama_agenda' => $agenda->nama_agenda,
            //         'waktu' => $agenda->waktu,
            //         'tempat' => $agenda->tempat,
            //         'point_beban_kerja' => $agenda->point_beban_kerja,
            //         'assignees' => $agenda->assignees->map(function ($assignee) {
            //             return [
            //                 'user_id' => $assignee->user_id,
            //                 'user_name' => $assignee->user->name ?? null,
            //                 'jabatan_id' => $assignee->jabatan_id,
            //                 'position_name' => $assignee->position->name ?? null,
            //                 'document_progress' => $assignee->document_progress
            //             ];
            //         }),
            //         'documents' => $agenda->documents ? $agenda->documents->map(function ($document) {
            //             return [
            // 'document_id' => $document->document_id,
            // 'file_name' => $document->file_name,
            // 'file_path' => $document->file_path,
            // 'upload_by' => $document->upload_by
            //             ];
            //         }) : [],
            //         // 'documents' => $agenda->documents->map(function ($document) {
            //         //     return [
            //         //         'document_id' => $document->document_id,
            //         //         'file_name' => $document->file_name,
            //         //         'file_path' => $document->file_path,
            //         //         'upload_by' => $document->upload_by
            //         //     ];
            //         // }) ,
            //     ];
            // });

            // Return response
            return response()->json([
                'status' => 'success',
                // 'data' => $formattedAgendas
                'data' => $agendas

            ], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch agendas.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Incoming request for creating an event', $request->all());

        $rules = [
            'event_name' => 'required|string|max:100',
            'event_description' => 'required|string',
            'start_date' => 'required|date',
            'event_code' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'jenis_event_id' => 'required',
            'user_id' => 'required|exists:m_user,user_id', 
            // 'participants' => 'nullable|array', // Array untuk peserta
            // 'participants.*.user_id' => 'nullable|exists:users,id', // Validasi setiap peserta
            'assign_letter' => 'nullable|file|mimes:pdf|max:2048', // Validasi file PDF
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){     
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $assignLetterPath = null;
        if ($request->hasFile('assign_letter')) {
            Log::info('Assign letter file found');
            $assignLetter = $request->file('assign_letter');
            $assignLetterPath = $assignLetter->storeAs(
                'docs',
                time() . '_' . $assignLetter->getClientOriginalName(),
                'public' // Disk public
            );
            Log::info('Assign letter file saved', ['path' => $assignLetterPath]);

        }

        try{
            DB::beginTransaction();

            $event = Event::create([
                'event_name' => $request->event_name,
                'event_description' => $request->event_description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'jenis_event_id' => $request->jenis_event_id,
                'event_code' => $request->event_code,
                'assign_letter' => $assignLetterPath,
                'status' => 'completed', 
            ]);

            EventParticipant::create([
                'event_id' => $event->event_id,
                'user_id' => $request->user_id, 
                'jabatan_id' => 1,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Event berhasil dibuat',
                'data' => $event,
            ], 201); 
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch agendas.',
                'error' => $e->getMessage()
            ], 500);
        }

        Log::info('Validation passed');

        $validated = $validator->validated();
        Log::info('Validation data', $validated);

        // Simpan file assign_letter jika ada
        $assignLetterPath = null;
        if ($request->hasFile('assign_letter')) {
            Log::info('Assign letter file found');
            $assignLetter = $request->file('assign_letter');
            $assignLetterPath = $assignLetter->storeAs(
                'docs',
                time() . '_' . $assignLetter->getClientOriginalName(),
                'public' // Disk public
            );
            Log::info('Assign letter file saved', ['path' => $assignLetterPath]);

        }
        Log::info('Creating event');

        // Simpan data event
        $event = Event::create([
            'event_name' => $validated['event_name'],
            'event_description' => $validated['event_description'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'jenis_event_id' => $validated['jenis_event_id'],
            'event_code' => $validated['event_code'],
            'assign_letter' => $assignLetterPath,
            'status' => 'completed', // Set status secara otomatis menjadi 'completed'
        ]);
        dd($event->id); 
        Log::info('Event created', ['event_id' => $event->id]);


        // Menyimpan data EventParticipant dengan user_id yang dikirim dari input
        $userId = $validated['user_id']; // Ambil user_id dari request
        $participantData = [
            'event_id' => $event->event_id,
            'user_id' => $userId, // Menggunakan user_id yang diterima dari input
            'jabatan_id' => 1, // Selalu diisi dengan nilai 1
            'created_at' => now(),
            'updated_at' => now(),
        ];

        Log::info('Participant data to be saved:', $participantData);
        EventParticipant::create($participantData); // Simpan data peserta ke EventParticipant
        Log::info('Participant data saved:', $participantData);


        $event->load('participants.user'); // Memuat relasi peserta untuk response

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dibuat',
            'data' => $event,
        ], 201);
    }
   
    public function show(Event $event)
    {
        // return EventModel::find($event);
        // Muat data relasi
        $event->load(['jenisEvent', 'participants']);

        return response()->json([
            'success' => true,
            'data' => $event,
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $event->update($request->all());
        return Event::find($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
