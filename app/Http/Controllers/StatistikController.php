<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Position;
use App\Models\Workload;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index()
    {
        $data = DB::table('event_participants')
        ->join('m_user', 'event_participants.user_id', '=', 'm_user.user_id')
        ->select('m_user.name', DB::raw('COUNT(event_participants.event_id) as total_events'))
        ->groupBy('m_user.name')
        ->orderBy('total_events', 'desc')
        ->get();

        $title = 'Statistik';
        $activeMenu = 'statistik';
        return view('statistik', ['data' => $data, 'title' => $title, 'activeMenu' => $activeMenu]);
    }
}
