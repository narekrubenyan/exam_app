<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tests')->truncate();

        DB::table('tests')->insert([
            [
                'title' => 'Տարբերակ 1',
            ],
            [
                'title' => 'Տարբերակ 2',
            ],
            [
                'title' => 'Տարբերակ 3',
            ],
            [
                'title' => 'Տարբերակ 4',
            ],
        ]);
    }
}
