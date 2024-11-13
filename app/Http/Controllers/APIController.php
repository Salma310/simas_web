<?php

namespace App\Http\Controllers;
use App\Models\api_data;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function index()
    {
        $data  = api_data::all();
        return $data;
    }
}
