<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Bilim',
            'Biznes',
            'Detetiw',
            'Edebiyat',
            'Ensiklopediya',
            'Filosofiya',
            'Iymit we Saglyk',
            'Okuw gollanmalary',
            'Romantika',
            'Şygyr',
            'Sport',
            'Taryh',
            'Ykdysadyýet',
            'Beyleki kitaplar',
            'Biografiya',
            'Çagalar üçin kitaplar',
            'Dürli diller',
            'Ene-ata we maşgala',
            'Fantaziýa',
            'Güýmenje',
            'Lukmançylyk',
            'Özüňi kämilleşdirmek',
            'Psihologiýa',
            'Sungat',
            'Syýahat',
            'Tehnologiýa',
            'Ylym',
        ];

        foreach ($brands as $brand) {
            $obj = new Brand();
            $obj->name = $brand;
            $obj->save();
        }
    }
}
