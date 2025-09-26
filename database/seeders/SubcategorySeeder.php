<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'Teknologi' => ['Artificial Intelligence','Internet of Things','Blockchain','Robotics','Biotechnology'],
            'Sosial' => ['Kewirausahaan Sosial','Pemberdayaan Masyarakat','Inklusi Sosial','Pengentasan Kemiskinan'],
            'Pendidikan' => ['EdTech','Metode Pembelajaran','Kurikulum','Assesmen Pendidikan'],
            'Humaniora' => ['Psikologi','Seni & Budaya','Filsafat','Sejarah','Antropologi'],
        ];

        foreach ($items as $category => $subs) {
            foreach ($subs as $name) {
                Subcategory::updateOrCreate([
                    'category' => $category,
                    'name' => $name,
                ]);
            }
        }
    }
}
