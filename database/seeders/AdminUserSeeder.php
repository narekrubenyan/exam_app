<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::query()->create([
        //     'name' => 'admin',
        //     'email' => 'moderator@test.am',
        //     'password' => Hash::make('test1234')
        // ]);
    }
}
