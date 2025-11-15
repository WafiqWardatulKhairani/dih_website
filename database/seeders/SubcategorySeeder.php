<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar subkategori berdasarkan kategori
        $data = [
            'Teknologi' => [
                'Artificial Intelligence',
                'Internet of Things',
                'Sistem Informasi Akademik',
                'Robotics',
                'Biotechnology',
            ],
            'Sosial' => [
                'Kewirausahaan Sosial',
                'Pemberdayaan Masyarakat',
                'Inklusi Sosial',
                'Pengentasan Kemiskinan',
            ],
            'Pendidikan' => [
                'EdTech',
                'Metode Pembelajaran',
                'Kurikulum',
                'Assesmen Pendidikan',
            ],
            'Humaniora' => [
                'Psikologi',
                'Seni & Budaya',
                'Filsafat',
                'Sejarah',
                'Antropologi',
            ],
        ];

        foreach ($data as $categoryName => $subNames) {
            // Ambil atau buat kategori utama
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($subNames as $subName) {
                // Hindari duplikasi, update jika sudah ada
                Subcategory::updateOrCreate(
                    [
                        'name' => $subName,
                        'category_id' => $category->id,
                    ],
                    [
                        'category_id' => $category->id,
                    ]
                );
            }
        }

        $this->command->info('✅ SubcategorySeeder berhasil dijalankan!');
    }
}
