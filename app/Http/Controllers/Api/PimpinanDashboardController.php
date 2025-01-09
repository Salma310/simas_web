<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Workload;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PimpinanDashboardController extends Controller
{
    public function getDosenEventChart()
    {
        // Mengambil semua data Workload dengan relasi User
        $workloads = Workload::with('user')
                ->where('period', '2024-2025') // Filter berdasarkan periode
                ->get();
        Log::info($workloads);


        Log::info('Fetched Workloads with User relations', ['count' => $workloads->count()]);


        $lecturerEventCounts = [];

        // Menghitung total earned_points per dosen
        foreach ($workloads as $workload) {
            $lecturer = $workload->user; // Mendapatkan data dosen dari relasi 'user'

            // Jika dosen sudah ada dalam array, tambahkan earned_points-nya
            if (isset($lecturerEventCounts[$lecturer->user_id])) {
                $lecturerEventCounts[$lecturer->user_id]['earned_points'] += $workload->earned_points;
            } else {
                // Jika dosen belum ada dalam array, buat entri baru
                $lecturerEventCounts[$lecturer->user_id] = [
                    'user_id' => $lecturer->user_id,
                    'name' => $lecturer->name,
                    'earned_points' => $workload->earned_points,
                ];
            }
        }

        // Menyusun data akhir untuk dikembalikan dalam response
        $lecturerEventCounts = array_values($lecturerEventCounts);

        Log::info('Returning final lecturer data', ['lecturers_count' => count($lecturerEventCounts)]);

        return response()->json([
            'status' => 'success',
            'data' => [
                "lecturers" => $lecturerEventCounts
            ],
        ]);
    }


    // function getDosenEventChart()
    // {

    //     $lecturers = User::all();

    //     $lecturerEventCounts = [];
    
    //     // Menghitung jumlah event yang diikuti oleh masing-masing dosen
    //     foreach ($lecturers as $lecturer) {
    //         $eventCount = EventParticipant::where('user_id', $lecturer->user_id)->count();
    //         $lecturerEventCounts[] = [
    //             'user_id' => $lecturer->user_id,
    //             'name' => $lecturer->name,
    //             'event_count' => $eventCount,
    //         ];
    //     }

    //     //  // Iterasi dosen dan hitung jumlah event yang diikuti
    //     // $lecturersWithEventCount = $lecturers->map(function ($lecturer) {
    //     //     // Hitung jumlah event yang diikuti oleh user ini
    //     //     $eventCount = EventParticipant::where('user_id', $lecturer->user_id)->count();

    //     //     // Tambahkan jumlah event ke data dosen
    //     //     $lecturer->event_count = $eventCount;
    //     //     return $lecturer;
    //     // });

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             "lecturers" => $lecturerEventCounts
    //         ],
    //     ]);
    // }
}
