<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,      // buat user admin dulu
            CategorySeeder::class,       // kategori dulu
            SubcategorySeeder::class,    // baru subkategori
            UserSeeder::class,           // user lain
            ProgramSeeder::class,        // program terkait
        ]);
    }
}
