<?php

namespace App\Http\Controllers;

use App\Models\Role; // Model RoleUser sesuai dengan tabel role user
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class RoleUserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Role']
        ];

        $activeMenu = 'role';

        return view('role.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function getRoles()
    {
        // Fetch all roles from the database
        $role = Role::all();

        // Return the roles as a JSON response
        return response()->json($role);
    }

    public function create()
    {
        return view('role.create');
    }

    public function show($role_id)
    {
    $role = Role::find($role_id);
    if (!$role) {
        return response()->json(['status' => false, 'message' => 'Role tidak ditemukan'], 404);
    }
    return response()->json(['status' => true, 'data' => $role]);
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validation rules for role user
            $rules = [
                'role_code' => 'required|string|min:3|unique:role_users,role_code',
                'role_name' => 'required|string|max:100',
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
                    'role_code' => $request->role_code,
                    'role_name' => $request->role_name,
                ];

                // Save data
                Role::create($data);

                // Success response
                return response()->json([
                    'status' => true,
                    'message' => 'Data role berhasil disimpan'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal menyimpan data role: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid request method'
        ], 400);
    }
}