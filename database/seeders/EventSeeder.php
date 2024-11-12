<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'event_kode' => 'EVT202401',
                'event_jenis' => 'Seminar',
                'event_name' => 'Seminar Nasional JTI',
                'event_deskripsi' => 'Seminar Nasional JTI dengan mengundang narasumber dari Kementerian Pendidikan',
            ],
            [
                'event_kode' => 'EVT202402',
                'event_jenis' => 'Lomba',
                'event_name' => 'Play It Fest',
                'event_deskripsi' => 'Perlombaan tingkat Nasional tentang IT',
            ],
            [
                'event_kode' => 'EVT202403',
                'event_jenis' => 'Workshop',
                'event_name' => 'Workshop JTI',
                'event_deskripsi' => 'Workshop yang diadakan 6 bulan sekali untuk dosen JTI',
            ],
        ];
        DB::table('m_event')->insert($data);
    }
}
