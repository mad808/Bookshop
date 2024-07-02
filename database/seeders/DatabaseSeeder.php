<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Year;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            YearSeeder::class,
            BooklangSeeder::class,
            UserSeeder::class,
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Book::factory(150)->create();
    }
}
