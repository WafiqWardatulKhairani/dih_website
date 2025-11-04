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
        // Daftar subkategori per kategori
        $items = [
            'Teknologi' => [
                'Artificial Intelligence',
                'Internet of Things',
                'Sistem Informasi Akademik',
                'Robotics',
                'Biotechnology'
            ],
            'Sosial' => [
                'Kewirausahaan Sosial',
                'Pemberdayaan Masyarakat',
                'Inklusi Sosial',
                'Pengentasan Kemiskinan'
            ],
            'Pendidikan' => [
                'EdTech',
                'Metode Pembelajaran',
                'Kurikulum',
                'Assesmen Pendidikan'
            ],
            'Humaniora' => [
                'Psikologi',
                'Seni & Budaya',
                'Filsafat',
                'Sejarah',
                'Antropologi'
            ],
        ];

        foreach ($items as $categoryName => $subs) {
            // Ambil category dari tabel categories atau buat baru jika belum ada
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($subs as $subName) {
                // Buat atau update subkategori berdasarkan name dan category_id
                Subcategory::updateOrCreate(
                    [
                        'name' => $subName,
                        'category_id' => $category->id
                    ],
                    [
                        'name' => $subName,
                        'category_id' => $category->id
                    ]
                );
            }
        }

        $this->command->info('SubcategorySeeder berhasil dijalankan!');
    }
}
