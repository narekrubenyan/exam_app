<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert([
            ['name' => 'Օրթոպեդիկ Ստոմատոլոգիա'],
            ['name' => 'Վիրաբուժական Ստոմատոլոգիա'],
            ['name' => 'Թերապեվտիկ Ստոմատոլոգիա'],
            ['name' => 'Պատ.Ֆիզ'],
            ['name' => 'Մանկական Ստոմատոլոգիա'],
            ['name' => 'Ֆարմակոլոգիա'],
            ['name' => 'Ստոմատոլոգիական հիվանդությունների պրոպեդեւտիկա'],
            ['name' => 'Օրթոդոնտիա'],
        ]);
    }
}
