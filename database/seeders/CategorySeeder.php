<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Teknologi',
            'Sosial',
            'Pendidikan',
            'Humaniora',
        ];

        foreach ($categories as $cat) {
            // Gunakan updateOrCreate supaya bisa dijalankan berulang kali tanpa error
            Category::updateOrCreate(
                ['name' => $cat], // kondisi unik
                ['name' => $cat]  // data yang akan di-update atau dibuat
            );
        }

        $this->command->info('CategorySeeder berhasil dijalankan!');
    }
}
