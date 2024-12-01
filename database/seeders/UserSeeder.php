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
                'role_id' => '1',
                'username' => 'dewilestari',
                'email' => 'dewilestari@gmail.com',
                'password' => Hash::make('123456'),
                'name' => 'Dewi Lestari',
                'phone' => '081234564849',
                'picture' => '',
                'auth_token' => '',
                'device_token' => '',
                'created_at' => '2024-11-13 05:17:44',
                'updated_at' => '2024-11-13 05:17:44',
            ],
            [
                'role_id' => '2',
                'username' => 'aimandestra',
                'email' => 'aimandestra123@gmail.com',
                'password' => Hash::make('234567'),
                'name' => 'Aiman Destra Jubran',
                'phone' => '0813788283727',
                'picture' => '',
                'auth_token' => '',
                'device_token' => '',
                'created_at' => '2024-11-13 05:19:43',
                'updated_at' => '2024-11-13 05:19:43',
            ],
            [
                'role_id' => '2',
                'username' => 'rakha123',
                'email' => 'rakha123@gmail.com',
                'password' => Hash::make('789090'),
                'name' => 'Ryan Rakha Nugraha',
                'phone' => '082726262527',
                'picture' => '',
                'auth_token' => '',
                'device_token' => '',
                'created_at' => '2024-11-13 05:19:43',
                'updated_at' => '2024-11-13 05:19:43',
            ],
            [
                'role_id' => '3',
                'username' => 'bagus123',
                'email' => 'baguschyo@gmail.com',
                'password' => Hash::make('123456'),
                'name' => 'Bagus Cahyo Hardono',
                'phone' => '083363742922',
                'picture' => '',
                'auth_token' => '',
                'device_token' => '',
                'created_at' => '2024-11-16 13:53:49',
                'updated_at' => '2024-11-16 13:53:49',
            ],
            [
                'role_id' => '3',
                'username' => 'rizki456',
                'email' => 'rizki@gmail.com',
                'password' => Hash::make('123456'),
                'name' => 'Rizki Pratama',
                'phone' => '083363742923',
                'picture' => '',
                'auth_token' => '',
                'device_token' => '',
                'created_at' => '2024-11-16 13:55:26',
                'updated_at' => '2024-11-16 13:55:26',
            ],
            [
                'user_id' => 2,
                'role_id' => 2,
                'username' => 'pimpinan',
                'email' => 'pimpinan@example.com',
                'name' => 'Saya Admin',
                'phone' => '085678942314',
                'password' => Hash::make('12345'),
            ],
            [
                'user_id' => 3,
                'role_id' => 3,
                'username' => 'dosen',
                'name' => 'Saya Admin',
                'phone' => '085678942314',
                'email' => 'dosen@example.com',
                'password' => Hash::make('12345'),
            ],
        ];
        DB::table('m_user')->insert($data);
    }
}
