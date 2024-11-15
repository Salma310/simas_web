<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
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

    public function list(Request $request)
    {
        $jenis = EventType::select('jenis_event_id','jenis_event_code','jenis_event_name');

        return DataTables::of($jenis)
            ->addIndexColumn()
            ->addColumn('aksi', function ($jenis) {
                $btn = '<button onclick="modalAction(\'' . url("jenis/$jenis->jenis_event_id/edit").'\')" class="btn btn-light"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\''.url("jenis/$jenis->jenis_event_id/delete").'\')" class="btn btn-light text-danger"><i class="fas fa-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->toJson();
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
                'jenis_event_name' => 'required|string|max:100',
                'jenis_event_code' => 'required|string|min:3|unique:t_jenis_event,jenis_event_code',
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
                    'jenis_event_name' => $request->jenis_event_name,
                    'jenis_event_code' => $request->jenis_event_code,
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

    public function edit(string $id)
        {
            $jenis = EventType::find($id);

            return view('jenis.edit', ['jenis' => $jenis]);
        }

    public function update(Request $request, $id)
        {
            if ($request->ajax() || $request->wantsJson()) {
                try {
                    // Validasi input
                    $rules = [
                        'jenis_event_name' => 'required|string|max:100',
                        'jenis_event_code' => 'required|string|min:3|unique:t_jenis_event,jenis_event_code',
                    ];

                    $validator = Validator::make($request->all(), $rules);

                    if ($validator->fails()) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Validasi gagal',
                            'msgField' => $validator->errors()
                        ]);
                    }

                    // Ambil data Jenis yang akan diupdate
                    $jenis = EventType::find($id);

                    if (!$jenis) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Jenis tidak ditemukan'
                        ]);
                    }

                    // Update data Jenis
                    $jenis->jenis_event_code = $request->jenis_event_code;
                    $jenis->jenis_event_name = $request->jenis_event_name;
                    $jenis->save();

                    return response()->json([
                        'status' => true,
                        'message' => 'Data Jenis berhasil diupdate',
                        'data' => [
                            'jenis_event_code' => $jenis->jenis_event_code,
                            'jenis_event_name' => $jenis->jenis_event_name
                        ]
                    ]);


                } catch (\Exception $e) {
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

    public function confirm(String $id){
            $jenis = EventType::find($id);
            return view('jenis.confirm', ['jenis' => $jenis]);
        }

    public function delete(Request $request, $id)
        {
            // Cek apakah request berasal dari Ajax atau menginginkan JSON response
            if ($request->ajax() || $request->wantsJson()) {
                // Cari jenis berdasarkan ID
                $jenis = EventType::find($id);
                if ($jenis) {
                    // Hapus data jenis
                    $jenis->delete();
                    // Kirim respon berhasil
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus',
                    ]);
                } else {
                    // Kirim respon gagal jika data tidak ditemukan
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan',
                    ]);
                }
            }

            // Redirect jika request tidak berasal dari Ajax
            return redirect('/');
        }

}

