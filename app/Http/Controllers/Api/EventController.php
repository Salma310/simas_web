<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = EventModel::all();

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
        // $events = EventModel::all(); // Mengambil semua data dari tabel m_event
        // return response()->json($events); // Mengembalikan data dalam format JSON
    }



    public function store(Request $request)
    {
        $event = EventModel::create($request->all());
        return response()->json($event, 201);
    }

    public function show(EventModel $event)
    {
        return EventModel::find($event);
    }

    public function update(Request $request, EventModel $event)
    {
        $event->update($request->all());
        return EventModel::find($event);
    }

    public function destroy(EventModel $event)
    {
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
