<?php
// app/Http/Controllers/KolaborasiController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KolaborasiController extends Controller
{
    public function index()
    {
        // Data dummy untuk contoh
        $kolaborasiAktif = [
            [
                'id' => 1,
                'judul' => 'Sistem IoT Monitoring Banjir',
                'deskripsi' => 'Pengembangan sistem real-time monitoring ketinggian air sungai',
                'progress' => 75,
                'anggota' => [
                    ['nama' => 'Dinas PUPR', 'role' => 'Pemerintah'],
                    ['nama' => 'Dr. Andri', 'role' => 'Akademisi'],
                    ['nama' => 'CV. TechSolution', 'role' => 'UMKM']
                ],
                'kategori' => 'Teknologi',
                'deadline' => '2024-12-31',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'judul' => 'Digitalisasi UMKM Pasar Tradisional',
                'deskripsi' => 'Membantu UMKM pasar tradisional go digital',
                'progress' => 30,
                'anggota' => [
                    ['nama' => 'Dinas Koperasi', 'role' => 'Pemerintah'],
                    ['nama' => 'Fakultas Ekonomi UNRI', 'role' => 'Akademisi']
                ],
                'kategori' => 'Ekonomi',
                'deadline' => '2024-11-15',
                'status' => 'active'
            ]
        ];

        $ideKolaborasi = [
            [
                'id' => 1,
                'judul' => 'Smart Parking System',
                'deskripsi' => 'Sistem parkir pintar untuk area perkotaan',
                'pemilik' => 'Diskominfo Kota',
                'kategori' => 'Smart City',
                'vote' => 15,
                'status' => 'open'
            ],
            [
                'id' => 2,
                'judul' => 'Aplikasi Laporan Pengaduan Masyarakat',
                'deskripsi' => 'Platform digital untuk pengaduan dan aspirasi masyarakat',
                'pemilik' => 'Dinas Komunikasi',
                'kategori' => 'Layanan Publik',
                'vote' => 23,
                'status' => 'open'
            ]
        ];

        return view('kolaborasi.index', compact('kolaborasiAktif', 'ideKolaborasi'));
    }

    public function show($id)
    {
        // Detail kolaborasi
        return view('kolaborasi.detail', compact('id'));
    }

    public function create()
    {
        return view('kolaborasi.create');
    }
}