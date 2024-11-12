<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'user_id' => 1,
                'name' => 'Saya Admin',
                'nidn' => '0123456789',
                'phone' => '085678942314',
            ],
            [
                'user_id' => 2,
                'name' => 'Saya Pimpinan',
                'nidn' => '0001112223',
                'phone' => '084354786548',
            ],
            [
                'user_id' => 3,
                'name' => 'Saya Dosen',
                'nidn' => '112233445',
                'phone' => '084354786548',
            ],
        ];
        DB::table('m_profile')->insert($data);
    }
}
