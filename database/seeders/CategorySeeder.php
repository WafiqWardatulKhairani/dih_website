<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Teknologi',
            'Sosial',
            'Pendidikan',
            'Humaniora',
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['name' => $cat]);
        }
    }
}
