<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoleModel;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return RoleModel::all();
    }

    public function store(Request $request)
    {
        $role = RoleModel::create($request->all());
        return response()->json($role, 201);
    }

    public function show(RoleModel $role)
    {
        return RoleModel::find($role);
    }

    public function update(Request $request, RoleModel $role)
    {
        $role->update($request->all());
        return RoleModel::find($role);
    }

    public function destroy(RoleModel $role)
    {
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
