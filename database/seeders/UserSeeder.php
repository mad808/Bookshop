<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'admin' => 1,
            'name' => 'Abdy',
            'phone' => 61000000,
            'password' => bcrypt('123456'),
        ]);
    }
}