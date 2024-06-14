<?php

namespace Database\Seeders;

use App\Models\Booklang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooklangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booklangs = [
            'Iňlis',
            'Rus',
            'Türkmen',
            'Türk',
        ];

        foreach ($booklangs as $booklang) {
            $obj = new Booklang();
            $obj->name = $booklang;
            $obj->save();
        }
    }
}
