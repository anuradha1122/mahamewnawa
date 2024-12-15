<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_categories')->truncate();

        $data = [
            ['id' => 1, 'name' => 'Swamin Wahanse'],
            ['id' => 2, 'name' => 'Gihi'],
        ];

        DB::table('user_categories')->insert($data);
    }
}
