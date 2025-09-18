<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramPemerintah;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        ProgramPemerintah::create([
            'title' => 'Transformasi Digital Pelayanan Publik',
            'category' => 'Digital Governance',
            'opd' => 'Dinas Kominfo',
            'badge' => 'BARU',
            'description' => 'Mencari solusi untuk meningkatkan kualitas pelayanan publik melalui transformasi digital.',
            'image' => 'https://via.placeholder.com/400x300?text=Digital+Governance',
        ]);

        ProgramPemerintah::create([
            'title' => 'Smart Waste Management System',
            'category' => 'Lingkungan',
            'opd' => 'DLH',
            'badge' => 'POPULER',
            'description' => 'Pengembangan sistem cerdas untuk optimalisasi pengelolaan sampah perkotaan.',
            'image' => 'https://via.placeholder.com/400x300?text=Smart+Waste',
        ]);

        ProgramPemerintah::create([
            'title' => 'Modernisasi Pertanian Perkotaan',
            'category' => 'Pertanian',
            'opd' => 'Dinas Pertanian',
            'badge' => null,
            'description' => 'Mengembangkan model pertanian perkotaan berbasis teknologi untuk ketahanan pangan.',
            'image' => 'https://via.placeholder.com/400x300?text=Pertanian+Digital',
        ]);
    }
}
