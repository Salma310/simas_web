<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class AgendaController extends Controller
{
    public function index(){

        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'Agenda';

        return view('agenda.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}