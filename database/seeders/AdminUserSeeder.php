<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'admin@test.am',
                'password' => Hash::make('test1234')
            ],
            [
                'username' => 'admin-armedin-2025',
                'email' => 'admin-armedin@test.am',
                'password' => Hash::make('Armedin-2025-pass')
            ]
        ]);
    }
}
