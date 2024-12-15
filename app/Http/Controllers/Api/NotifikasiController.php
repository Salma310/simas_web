<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\EventNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
// use App\Models\Notification;
class NotifikasiController extends Controller
{

    public function index()
    {

        // Ambil semua user_id dari tabel m_user sebagai array
        $user_ids = User::pluck('user_id')->toArray(); // Mengambil hanya kolom user_id

        $notifikasi = DB::table('notifications')
            ->select('id', 'type', 'data', 'notifiable_type', 'notifiable_id', 'data', 'read_at', 'created_at')
            ->whereIn('notifiable_id', $user_ids)
            ->get()
            ->map(function ($notification) {
                $data = json_decode($notification->data, true);

                    return [
                        'event_id' => $data['event_id'] ?? null,
                        'event_name' => $data['event_name'] ?? null,
                        'title' => $data['title'] ?? null,
                        'message' => $data['message'] ?? null,
                        'created_at' => $notification->created_at, // Tambahkan created_at
                    ];
            });

        return $notifikasi;
    }

    public function show(Request $request)
    {
        $notifikasi = Notification::all()->where('notification_id', $request->id)->first();
        return $notifikasi;
    }
}
