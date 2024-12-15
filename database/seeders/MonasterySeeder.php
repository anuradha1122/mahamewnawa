<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonasterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('monasteries')->truncate();

        $data = array(
            array('name' => 'Polgahawela Monastery','censusNo' => NULL,'addressLine1' => 'no1','addressLine2' => 'Yangalmodara','addressLine3' => 'Polgahawela','mobile' => '0715193212','higherMonasteryId' => NULL, 'active' => 1),
            array('name' => 'Malambe Monastery','censusNo' => NULL,'addressLine1' => 'no 2','addressLine2' => 'New Kandy Road','addressLine3' => 'malambe','mobile' => '0715192212','higherMonasteryId' => 1, 'active' => 1),
        );

        DB::table('monasteries')->insert($data);
    }
}
