<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\OptionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            OptionSeeder::class,
            // CategoryAndQuestionSeeder::class,
        ]);
    }
}
