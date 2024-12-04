<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Position;
use App\Models\Workload;

class StatistikController extends Controller
{
    public function index()
    {
        $position = Position::all();
        $agenda = Agenda::all();
        $workload = Workload::all();

        $title = 'Statistik';
        $activeMenu = 'statistik';
        return view('statistik', ['position' => $position, 'agenda' => $agenda, 'workload' => $workload, 'activeMenu' => $activeMenu, 'title' => $title]);
    }
}
