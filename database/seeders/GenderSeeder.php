<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genders')->truncate();

        $data = [
            ['id' => 1, 'name' => 'Male'],
            ['id' => 2, 'name' => 'Female'],
        ];

        DB::table('genders')->insert($data);
    }
}
