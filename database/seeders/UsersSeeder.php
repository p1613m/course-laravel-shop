<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insertOrIgnore([
            [
                'id' => 1,
                'full_name' => 'Admin',
                'email' => 'admin@shop.ru',
                'password' => Hash::make('QWEasd123'),
                'is_admin' => true,
            ],
            [
                'id' => 2,
                'full_name' => 'Client',
                'email' => 'user@shop.ru',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ],
        ]);
    }
}
