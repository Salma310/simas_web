<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Position;
use App\Models\Workload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index()
    {
        $position = Position::all();
        $agenda = Agenda::all();

        // Dapatkan semua period yang unik
        $periods = Workload::select('period')
                    ->distinct()
                    ->orderBy('period', 'desc')
                    ->get();

        // Jika ada request period, gunakan itu. Jika tidak, gunakan period terbaru
        $selectedPeriod = request('period', $periods->first()->period ?? null);

        // Dapatkan data workload yang sudah dikelompokkan per user
        $workloadData = Workload::with('user')
                    ->where('period', $selectedPeriod)
                    ->select('user_id', DB::raw('SUM(earned_points) as total_points'))
                    ->groupBy('user_id')
                    ->orderBy('total_points', 'desc')  // Urutkan berdasarkan total point tertinggi
                    ->get();

                    return view('statistik', [
                        'position' => $position,
                        'agenda' => $agenda,
                        'workloadData' => $workloadData,
                        'periods' => $periods,
                        'selectedPeriod' => $selectedPeriod,
                        'activeMenu' => 'statistik',
                        'title' => 'Statistik'
                    ]);
    }
}
