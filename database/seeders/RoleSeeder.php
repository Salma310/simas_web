<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['role_id' =>1, 'role_kode' => 'ADM', 'role_nama' => 'Administrator'],
            ['role_id' =>2, 'role_kode' => 'PMP', 'role_nama' => 'Pimpinan'],
            ['role_id' =>3, 'role_kode' => 'DSN', 'role_nama' => 'Dosen'],
        ];
        DB::table('m_role')->insert($data);
    }
}
