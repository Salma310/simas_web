<?php

namespace App\Http\Controllers\dosen;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Agenda;
use Illuminate\Http\Request;
use App\Models\AgendaAssignee;
use App\Models\AgendaDocument;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\dosen\Controller;

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
                $btn = '<button onclick="modalAction(\'' . route('agenda.edit', ['id' => $agendas->event_id, 'id_agenda' => $agendas->agenda_id]) . '\')" class="btn btn-light"><i class="fas fa-edit"></i></button>';
                $btn .= '<button onclick="modalAction(\''.url("event_dosen/$agendas->event_id/agendaPIC/$agendas->agenda_id/delete").'\')" class="btn btn-light text-danger"><i class="fas fa-trash"></i></button>';
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
                'dokumen_pendukung.*' => 'nullable|file|mimes:jpeg,png,pdf,doc,docx,xls,xlsx|max:5120'
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

                // Handle document uploads
                if ($request->hasFile('dokumen_pendukung')) {
                    foreach ($request->file('dokumen_pendukung') as $file) {
                        $path = $file->store('agenda_documents', 'public');
                        AgendaDocument::create([
                            'agenda_id' => $agenda->agenda_id,
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $path,
                            'file_type' => $file->getClientOriginalExtension(),
                        ]);
                    }
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

    public function edit($id, $id_agenda)
    {
        $agenda = Agenda::with(['documents', 'assignees.user', 'assignees.position'])
            ->findOrFail($id_agenda);
            $agenda->start_date = Carbon::parse($agenda->start_date)->format('Y-m-d');
            $agenda->end_date = Carbon::parse($agenda->end_date)->format('Y-m-d');

        $event = Event::with(['participants.user', 'participants.position'])
            ->findOrFail($id);

        return view('dosen.event.agenda.edit', compact('agenda', 'event'));
    }


    public function update(Request $request, $id, $id_agenda)
{
    try {
        DB::beginTransaction();

        // Validate main agenda data
        $validator = Validator::make($request->all(), [
            'nama_agenda' => 'required|min:3',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'tempat' => 'required',
            'jabatan_id' => 'required|exists:m_jabatan,jabatan_id',
            'status' => 'required|in:not started,progress,done',
            'dokumen_pendukung.*' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
            'assignees' => 'required|array|min:1',
            'assignees.*.user_id' => 'required|exists:m_user,user_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update agenda
        $agenda = Agenda::findOrFail($id_agenda);
        $agenda->update([
            'nama_agenda' => $request->nama_agenda,
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d H:i:s'),
            'end_date' => Carbon::parse($request->end_date)->format('Y-m-d H:i:s'),
            'tempat' => $request->tempat,
            'jabatan_id' => $request->jabatan_id,
            'status' => $request->status,
        ]);

        // Handle document uploads
        if ($request->hasFile('dokumen_pendukung')) {
            foreach ($request->file('dokumen_pendukung') as $file) {
                $path = $file->store('agenda_documents', 'public');
                AgendaDocument::create([
                    'agenda_id' => $agenda->agenda_id,
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                ]);
            }
        }

       // Update assignees - hapus semua assignee lama jika ada
       if ($agenda->assignees) {
        AgendaAssignee::where('agenda_id', $agenda->agenda_id)->delete();
        }


        foreach ($request->assignees as $assignee) {
            AgendaAssignee::create([
                'agenda_id' => $agenda->agenda_id,
                'user_id' => $assignee['user_id'],
                'jabatan_id' => $agenda->jabatan_id, // Use agenda's jabatan_id
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Agenda berhasil diperbarui'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}
    public function deleteDocument($id, $id_agenda, $document_id)
    {
        try {
            $document = AgendaDocument::findOrFail($document_id);

            // Delete file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Delete record from database
            $document->delete();

            return response()->json([
                'status' => true,
                'message' => 'Dokumen berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus dokumen: ' . $e->getMessage()
            ], 500);
        }
    }

    public function confirm($id, $id_agenda)
    {
        $agenda = Agenda::with(['documents', 'assignees.user', 'assignees.position'])
            ->findOrFail($id_agenda);
            $agenda->start_date = Carbon::parse($agenda->start_date)->format('Y-m-d');
            $agenda->end_date = Carbon::parse($agenda->end_date)->format('Y-m-d');

        $event = Event::with(['participants.user', 'participants.position'])
            ->findOrFail($id);

        return view('dosen.event.agenda.confirm', compact('agenda', 'event'));
    }

    public function delete($id, $id_agenda)
    {
        try {
            $agenda = Agenda::where('agenda_id', $id_agenda)
                ->where('event_id', $id)
                ->firstOrFail();

            $agenda->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data agenda berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data agenda',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Agenda $agenda)
    {
        // Tambahkan relasi yang ingin ditampilkan
        $agenda->load('event', 'assignees', 'documents', 'workloads');
        return view('agenda.show', compact('agenda'));
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
        $activeMenu = 'event dosen';

        return view('dosen.event.agendaAGT.index', compact('agendas', 'event', 'title', 'activeMenu'));
    }

    public function listAGT(Request $request){
        $eventId = $request->get('event_id'); // Ambil event_id dari request

        // Query data berdasarkan event_id
        $agendas = Agenda::with('assignees.user')->where('event_id', $eventId)->get();


        return DataTables::of($agendas)
            ->addIndexColumn()
            ->toJson();
    }

    public function showAGT(Request $request, $id, $id_agenda)
{
    // Query satu data agenda berdasarkan event_id dan id_agenda
    $agenda = Agenda::with('documents','assignees.user')
        ->where('event_id', $id)
        ->where('agenda_id', $id_agenda)
        ->first(); // Mengambil satu item saja

    // Jika tidak ditemukan, berikan respon error
    if (!$agenda) {
        abort(404, 'Agenda tidak ditemukan.');
    }

    return view('dosen.event.agendaAGT.show', compact('agenda'));
}

public function updateStatus(Request $request, $id, $id_agenda)
{
    $agenda = Agenda::where('event_id', $id)->findOrFail($id_agenda);

    $agenda->status = $request->input('status');
    $agenda->save();

    return response()->json(['success' => true, 'message' => 'Status berhasil diubah']);
}

public function download_Document($id, $id_agenda, $id_document)
{
    Log::info("Mengakses download_document dengan id: $id, id_agenda: $id_agenda, id_document: $id_document");

    $document = AgendaDocument::where('agenda_id', $id_agenda)
                        ->where('document_id', $id_document)
                        ->first();

    if (!$document) {
        Log::error("Dokumen tidak ditemukan untuk id: $id_document");
        return abort(404, 'Dokumen tidak ditemukan.');
    }

    $filePath = public_path('storage/' . $document->file_path);

    if (file_exists($filePath)) {
        Log::info("Mengunduh file: $filePath");
        return response()->download($filePath);
    } else {
        Log::error("File tidak ditemukan di path: $filePath");
        return abort(404, 'File tidak ditemukan.');
    }
}


/**
 * Handle upload of progress document for an agenda
 *
 * @param Request $request
 * @param int $id Event ID
 * @param int $id_agenda Agenda ID
 * @return JsonResponse
 */
public function uploadProgress(Request $request, $id, $id_agenda)
{
    $request->validate([
        'dokumen_progress' => 'required|file|max:5120|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png'
    ]);

    try {
        // Get currently logged in user
        $user = auth()->user();

        // Check if the logged-in user is assigned to this agenda
        $agenda = Agenda::where('agenda_id', $id_agenda)
            ->first();

        if (!$agenda) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk mengupload dokumen pada agenda ini',
            ], 403);
        }

        // Handle file upload
        $file = $request->file('dokumen_progress');

        // Generate unique filename
        $fileName = time() . '_' . $user->user_id . '_' . $file->getClientOriginalName();

        // Store file with custom filename
        $filePath = $file->storeAs('progress_documents', $fileName, 'public');

        if (!$filePath) {
            throw new \Exception('Gagal menyimpan file');
        }

        // Update agenda record using the correct primary key
        // Wrap the file path in quotes for the database
        $agenda->document_progress = $filePath;

        // Use the correct primary key columns for the update
        $result = DB::table('t_agenda')
            ->where('agenda_id', $id_agenda)
            ->update([
                'document_progress' => $filePath,
                'updated_at' => now()
            ]);

        if (!$result) {
            // If database update fails, delete the uploaded file
            Storage::disk('public')->delete($filePath);
            throw new \Exception('Gagal menyimpan data ke database');
        }

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Dokumen berhasil diupload',
            'data' => [
                'file_path' => $filePath,
                'uploaded_by' => $user->name,
                'upload_time' => now()->format('Y-m-d H:i:s')
            ]
        ]);

    } catch (\Exception $e) {
        // Log error untuk debugging
        Log::error('Error uploading progress document: ' . $e->getMessage(), [
            'user_id' => auth()->id(),
            'agenda_id' => $id_agenda,
            'event_id' => $id
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengupload dokumen: ' . $e->getMessage(),
        ], 500);
    }
}
    public function generateAllPoints(Request $request)
    {
        try {
            $event = Event::findOrFail($request->event_id);

            // Pastikan base total point sudah ditentukan
            if (!$event->point) {
                return response()->json([
                    'status' => false,
                    'message' => 'Base total point untuk event belum ditentukan'
                ], 400);
            }

            $result = Agenda::generatePointsByTopsis(
                $request->event_id,
                $event->point
            );

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal generate points: ' . $e->getMessage()
            ], 500);
        }
    }
}
