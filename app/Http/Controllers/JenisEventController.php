<?php

namespace App\Http\Controllers;
use App\Models\EventType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JenisEventController extends Controller
{
    public function index(){

        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'jenis event';

        return view('jenis.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function getEvents()
    {
        // Fetch all events from the database
        $jEvents = EventType::all();

        // Return the events as a JSON response
        return response()->json($jEvents);
    }

    public function create()
    {
        return view('jenis.create');
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validation rules
            $rules = [
                'jenis_event_code' => 'required|string|min:3|unique:jenis_event_id,jenis_event_code',
                'jenis_event_name' => 'required|string|max:100',
            ];

            // Validate input
            $validator = Validator::make($request->all(), $rules);

            // If validation fails, return response with error messages
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                // Prepare data to be saved
                $data = [
                    'jenis_event_code' => $request->jenis_event_code,
                    'jenis_event_name' => $request->jenis_event_name,
                ];

                // Save data
                EventType::create($data);

                // Success response
                return response()->json([
                    'status' => true,
                    'message' => 'Data jenis berhasil disimpan'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data jenis: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid request method'
        ], 400);
    }


}

