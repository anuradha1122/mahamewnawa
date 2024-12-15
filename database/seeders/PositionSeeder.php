<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->truncate();
        $data = [
            ['id' => 1, 'name' => 'Position 1'],
            ['id' => 2, 'name' => 'Position 2'],
            ['id' => 3, 'name' => 'Position 3'],
        ];

        DB::table('positions')->insert($data);
    }
}
