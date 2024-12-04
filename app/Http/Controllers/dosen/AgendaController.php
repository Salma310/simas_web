<?php

namespace App\Http\Controllers\dosen;

use App\Models\Event;
use App\Models\Agenda;
use Illuminate\Http\Request;
use App\Http\Controllers\dosen\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\QueryException;

class AgendaController extends Controller
{
    public function index($id = null) {
        $event = null;
        if ($id) {
            $event = Event::findOrFail($id);
            $agendas = Agenda::where('event_id', $id)->get();
        } else {
            $agendas = Agenda::all();
        }

        $title = 'List Agenda';
        $activeMenu = 'event dosen';

        return view('dosen.event.agenda.index', compact('agendas', 'event', 'title', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $eventId = $request->get('event_id'); // Ambil event_id dari request

        // Query data berdasarkan event_id
        $agendas = Agenda::where('event_id', $eventId)->get();


        return DataTables::of($agendas)
            ->addIndexColumn()
            ->addColumn('aksi', function ($agendas) {
                $btn = '<button onclick="modalAction(\'' . url("event_dosen/$agendas->agenda_id/edit").'\')" class="btn btn-light"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\''.url("event_dosen/$agendas->agenda_id/delete").'\')" class="btn btn-light text-danger"><i class="fas fa-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }


    public function create($id)
    {
        $event = Event::with('participants.position')->find($id);
        $agendas = Agenda::all();
        return view('dosen.event.agenda.create', compact('event', 'agendas'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validation rules
            $rules = [
                'event_id' => 'required|exists:m_event,event_id',
                'nama_agenda' => 'required|string|max:255',
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'tempat' => 'required|string|max:255',
                'jabatan_id' => 'required|exists:m_jabatan,jabatan_id',
                'status' => 'required|in:not started,progress,done',
                'dokumen_pendukung' => 'nullable|file|mimetypes:image/jpeg,image/png,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:5120'
            ];

            // Validate input
            $validator = Validator::make($request->all(), $rules);

            // If validation fails, return response with error messages
            if ($validator->fails()) {
                if ($request->hasFile('dokumen_pendukung')) {
                    $file = $request->file('dokumen_pendukung');
                    dd($file->getMimeType());
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                // Prepare data to be saved
                $data = [
                    'event_id' => $request->event_id,
                    'nama_agenda' => $request->nama_agenda,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'tempat' => $request->tempat,
                    'jabatan_id' => $request->jabatan_id,
                    'status' => $request->status,
                ];

                // Save agenda
                $agenda = Agenda::create($data);

                // Handle document upload
                if ($request->hasFile('dokumen_pendukung')) {
                    $file = $request->file('dokumen_pendukung');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('agenda_documents', $filename, 'public');

                    // Create document record associated with the agenda
                    $agenda->documents()->create([
                        'file_name' => $filename,
                        'file_path' => $path
                    ]);
                }

                // Success response
                return response()->json([
                    'status' => true,
                    'message' => 'Agenda berhasil disimpan'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan agenda: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid request method'
        ], 400);
    }


    public function edit(Agenda $agenda)
    {
        $events = \App\Models\Event::all(); // Ambil daftar event untuk dropdown
        return view('agenda.edit', compact('agenda', 'events'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|exists:t_event,event_id',
            'nama_agenda' => 'required|string|max:255',
            'waktu' => 'required|date',
            'tempat' => 'required|string|max:255',
            'point_beban_kerja' => 'required|numeric'
        ]);

        $agenda->update($validatedData);

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil diupdate');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil dihapus');
    }

    public function show(Agenda $agenda)
    {
        // Tambahkan relasi yang ingin ditampilkan
        $agenda->load('event', 'assignees', 'documents', 'workloads');
        return view('agenda.show', compact('agenda'));
    }
}
