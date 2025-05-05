<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('options')->truncate();

        DB::table('options')->insert([
            ['name' => 'Տարբերակ 1'],
            ['name' => 'Տարբերակ 2'],
            ['name' => 'Տարբերակ 3'],
            ['name' => 'Տարբերակ 4'],
        ]);
    }
}
