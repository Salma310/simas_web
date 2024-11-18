<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RoleUserController extends Controller
{

    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Role User',
            'list' => ['Home', 'Role User']
        ];

        $page = (object) [
            'title' => 'Daftar role yang terdaftar dalam sistem'
        ];
<<<<<<< HEAD
    
        $activeMenu = 'role user';
    
=======

        $activeMenu = 'role';

>>>>>>> 6cfb3dad2f45939848ce40006b569fd3af74bace
        return view('role.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $role = Role::select('role_id', 'role_code', 'role_name');

        return DataTables::of($role)
            ->addIndexColumn()
            ->addColumn('aksi', function ($role) {
                $btn = '<button onclick="modalAction(\'' . url('/role/' . $role->role_id .'/edit_ajax') . '\')" class="btn btn-light"><i class="fas fa-edit"></i></button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/role/' . $role->role_id .'/delete_ajax') . '\')" class="btn btn-light text-danger"><i class="fas fa-trash"></i></button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Role User',
            'list' => ['Home', 'Role User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Role Baru'
        ];

        $activeMenu = 'role user';

        return view('role.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request) {
        $request->validate([
            'role_name' => 'required|string|max:100',
            'role_code' => 'required|string|min:3|unique:m_role,role_code'
        ]);

        Role::create([
            'role_name' => $request->role_name,
            'role_code' => $request->role_code
        ]);

        return redirect('/role')->with('success', 'Data Role berhasil disimpan');
    }

    public function show(string $id) {
        $role = Role::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Role User',
            'list' => ['Home', 'Role User', 'Detail']
        ];

        $page = (object) [
            'title' =>  'Detail Role User'
        ];

        $activeMenu = 'role';

        return view('role.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'role' => $role, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id) {
        $role = Role::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Role User',
            'list' => ['Home', 'Role User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Role User'
        ];

        $activeMenu = 'role';

        return view('role.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'role' => $role, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id) {
        $request->validate([
            'role_name' => 'required|string|max:100',
            'role_code' => 'required|string|min:3|unique:m_role,role_code,' . $id . ',role_id'
        ]);

        Role::find($id)->update([
            'role_name' => $request->role_name,
            'role_code' => $request->role_code,
        ]);

        return redirect('/role')->with('success', 'Data Role berhasil diubah');
    }

    public function destroy(string $id) {
        $check = Role::find($id);
        if(!$check) {
            return redirect('/role')->with('error', 'Data role tidak ditemukan');
        }

        try {
            Role::destroy($id);
            return redirect('/role')->with('success', 'Data role berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/role')->with('error', 'Data role gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        return view('role.create_ajax');
    }

    public function show_ajax(string $id)
    {
        $role = Role::find($id);
        return view('role.show_ajax', ['role' => $role]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'role_name' => 'required|string|max:100',
                'role_code' => 'required|string|min:3|max:10|unique:m_role,role_code'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            Role::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data role berhasil disimpan',
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id) {
        $role = Role::find($id);
        return view('role.edit_ajax', ['role' => $role]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'role_name' => 'required|max:100',
                'role_code' => 'required|max:10|unique:m_role,role_code,' . $id . ',role_id'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $check = Role::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }
    public function confirm_ajax(string $id)
    {
        $role = Role::find($id);
        return view('role.confirm_ajax', ['role' => $role]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $level = Role::find($id);
            if ($level) {
                $level->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }
}
?>
