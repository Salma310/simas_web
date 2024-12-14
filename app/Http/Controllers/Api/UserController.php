<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
         //set validation
        $validator = Validator :: make($request->all(), [
            'username' => 'required',
            'name' => 'required',
            // 'email' => 'required',
            // 'phone' => 'required',
            'password' => 'required|min:5|confirmed',
            'role_id' => 'required',
            // 'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        //if validations fails
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        //create user
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        //return response JSON user is created
        if($user){
            return response()->json([
            'success' => true,
            'user' => $user,
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
        // $user = User::create($request->all());
        // return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'user' => $user,
        ]);
    }


    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return User::find($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
