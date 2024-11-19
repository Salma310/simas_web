<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();

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



    public function store(Request $request)
    {
        $event = Event::create($request->all());
        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return Event::find($event);
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
