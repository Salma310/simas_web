<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'user_id' => 1,
                'role_id' => 1,
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345'), // class untuk mengenkripsi/hash password
            ],
            [
                'user_id' => 2,
                'role_id' => 2,
                'username' => 'pimpinan',
                'email' => 'pimpinan@example.com',
                'password' => Hash::make('12345'), 
            ],
            [
                'user_id' => 3,
                'role_id' => 3,
                'username' => 'dosen',
                'email' => 'dosen@example.com',
                'password' => Hash::make('12345'), 
            ],
        ];
        DB::table('m_user')->insert($data);
    }
}
