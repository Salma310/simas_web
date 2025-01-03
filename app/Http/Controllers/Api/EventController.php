<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // $events = EventModel::all();
        $events = Event::with('jenisEvent', 'participants.user')->get();
        if ($events->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No events found',
                'data' => [],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Events found',
            'data' => $events,
    ]);
        // $events = Event::all(); // Mengambil semua data dari tabel m_event
        // return response()->json($events); // Mengembalikan data dalam format JSON
    }

    public function store(Request $request)
    {
        $event = Event::create($request->all());
        return response()->json($event, 201);
    }

    public function show(Event $event)
{
    // Muat data relasi seperti jenisEvent dan participants
    $event->load(['jenisEvent', 'participants.user']);

    return response()->json([
        'success' => true,
        'data' => [
            'event_id' => $event->event_id,
            'event_name' => $event->event_name,
            'status' => $event->status ?? 'Unknown',
            'jumlah_participants' => $event->participants->count(),
            'end_date' => $event->end_date,
        ],
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
