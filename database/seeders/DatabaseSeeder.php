<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(UserSeeder::class);
        $this->call(RaceSeeder::class);
        $this->call(ReligionSeeder::class);
        $this->call(CivilStatusSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(MonasterySeeder::class);
        $this->call(UserCategorySeeder::class);
        $this->call(PositionSeeder::class);
    }
}
