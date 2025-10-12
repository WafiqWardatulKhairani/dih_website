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
                'vote_progress' => 75,
                'vote_target' => 20,
                'tanggal' => '2024-10-15',
                'estimasi_waktu' => '6-12 bulan',
                'comments' => 8,
                'status' => 'open'
            ],
            [
                'id' => 2,
                'judul' => 'Aplikasi Laporan Pengaduan Masyarakat',
                'deskripsi' => 'Platform digital untuk pengaduan dan aspirasi masyarakat',
                'pemilik' => 'Dinas Komunikasi',
                'kategori' => 'Layanan Publik',
                'vote' => 23,
                'vote_progress' => 100,
                'vote_target' => 20,
                'tanggal' => '2024-10-10',
                'estimasi_waktu' => '3-6 bulan',
                'comments' => 15,
                'status' => 'approved'
            ]
        ];

        // Data untuk partials - TAMBAHAN BARU
        $myTasks = [
            [
                'judul' => 'Design UI Dashboard',
                'deskripsi' => 'Buat mockup dan design system untuk dashboard monitoring',
                'project' => 'IoT Monitoring Banjir',
                'priority' => 'high',
                'deadline' => '2024-10-30',
                'points' => 5,
                'status' => 'progress',
                'status_color' => 'yellow',
                'progress' => 60,
                'days_left' => 2
            ],
            [
                'judul' => 'Backend API Development',
                'deskripsi' => 'Develop REST API untuk data sensor dan user management',
                'project' => 'IoT Monitoring Banjir',
                'priority' => 'high',
                'deadline' => '2024-11-10',
                'points' => 8,
                'status' => 'todo',
                'status_color' => 'gray',
                'progress' => 0,
                'days_left' => 13
            ],
            [
                'judul' => 'Research Sensor Technology',
                'deskripsi' => 'Studi teknologi sensor ultrasonik untuk monitoring air',
                'project' => 'IoT Monitoring Banjir',
                'priority' => 'medium',
                'deadline' => '2024-11-05',
                'points' => 3,
                'status' => 'review',
                'status_color' => 'blue',
                'progress' => 100,
                'days_left' => 8
            ]
        ];

        $myGroups = [
            [
                'id' => 1,
                'nama' => 'Sistem IoT Monitoring Banjir',
                'deskripsi' => 'Pengembangan sistem monitoring real-time',
                'kategori' => 'Teknologi',
                'status' => 'active',
                'progress' => 75,
                'anggota' => [
                    ['nama' => 'Dinas PUPR', 'role' => 'Pemerintah'],
                    ['nama' => 'Dr. Andri', 'role' => 'Akademisi'],
                    ['nama' => 'CV. TechSolution', 'role' => 'UMKM']
                ],
                'deadline' => '2024-12-31',
                'unread_messages' => 3,
                'active_tasks' => 5
            ],
            [
                'id' => 2,
                'nama' => 'Digitalisasi UMKM',
                'deskripsi' => 'Transformasi digital UMKM tradisional',
                'kategori' => 'Ekonomi',
                'status' => 'active',
                'progress' => 30,
                'anggota' => [
                    ['nama' => 'Dinas Koperasi', 'role' => 'Pemerintah'],
                    ['nama' => 'Fakultas Ekonomi', 'role' => 'Akademisi']
                ],
                'deadline' => '2024-11-15',
                'unread_messages' => 0,
                'active_tasks' => 3
            ],
            [
                'id' => 3,
                'nama' => 'Smart City Initiative',
                'deskripsi' => 'Pengembangan solusi smart city terintegrasi',
                'kategori' => 'Smart City',
                'status' => 'planning',
                'progress' => 10,
                'anggota' => [
                    ['nama' => 'Diskominfo', 'role' => 'Pemerintah'],
                    ['nama' => 'Universitas Teknologi', 'role' => 'Akademisi']
                ],
                'deadline' => '2025-03-31',
                'unread_messages' => 7,
                'active_tasks' => 2
            ]
        ];

        return view('kolaborasi.index', compact('kolaborasiAktif', 'ideKolaborasi', 'myTasks', 'myGroups'));
    }

    public function show($id)
    {
        // Data dummy untuk detail kolaborasi
        $kolaborasi = [
            'id' => $id,
            'judul' => 'Sistem IoT Monitoring Banjir',
            'deskripsi' => 'Pengembangan sistem real-time monitoring ketinggian air sungai berbasis IoT dengan sensor ultrasonik dan platform dashboard real-time.',
            'progress' => 75,
            'anggota' => [
                ['nama' => 'Dinas PUPR', 'role' => 'Project Owner'],
                ['nama' => 'Dr. Andri', 'role' => 'Lead Researcher'],
                ['nama' => 'CV. TechSolution', 'role' => 'Developer'],
                ['nama' => 'Badan Lingkungan', 'role' => 'Stakeholder']
            ],
            'kategori' => 'Teknologi',
            'deadline' => '2024-12-31',
            'status' => 'active'
        ];

        // Tasks data for kanban board
        $tasks = [
            'todo' => [
                [
                    'id' => 1,
                    'judul' => 'Design UI Dashboard',
                    'deskripsi' => 'Buat mockup dan design system untuk dashboard monitoring',
                    'priority' => 'high',
                    'deadline' => '2024-10-30',
                    'assignees' => ['Dr. Andri'],
                    'points' => 5
                ],
                [
                    'id' => 2,
                    'judul' => 'Research Sensor Technology',
                    'deskripsi' => 'Studi teknologi sensor ultrasonik untuk monitoring air',
                    'priority' => 'medium',
                    'deadline' => '2024-11-05',
                    'assignees' => ['CV. TechSolution'],
                    'points' => 3
                ]
            ],
            'progress' => [
                [
                    'id' => 3,
                    'judul' => 'Backend API Development',
                    'deskripsi' => 'Develop REST API untuk data sensor dan user management',
                    'priority' => 'high',
                    'deadline' => '2024-11-10',
                    'assignees' => ['CV. TechSolution', 'Dr. Andri'],
                    'points' => 8
                ]
            ],
            'review' => [
                [
                    'id' => 4,
                    'judul' => 'Documentation v1.0',
                    'deskripsi' => 'Technical documentation untuk phase 1 development',
                    'priority' => 'low',
                    'deadline' => '2024-10-25',
                    'assignees' => ['Dinas PUPR'],
                    'points' => 2
                ]
            ],
            'done' => [
                [
                    'id' => 5,
                    'judul' => 'Project Setup & Planning',
                    'deskripsi' => 'Initial project setup dan timeline planning',
                    'priority' => 'medium',
                    'deadline' => '2024-10-20',
                    'assignees' => ['Dr. Andri'],
                    'points' => 3
                ]
            ]
        ];

        // Discussion data
        $discussions = [
            [
                'user' => 'Dr. Andri',
                'time' => '2 jam yang lalu',
                'message' => 'Saya sudah selesai dengan research awal untuk sensor technology. Ada beberapa opsi yang bisa kita pertimbangkan...',
                'likes' => 3
            ],
            [
                'user' => 'CV. TechSolution',
                'time' => '5 jam yang lalu', 
                'message' => 'Progress backend API sudah 70% complete. Untuk authentication system, saya sarankan pakai JWT.',
                'likes' => 1
            ],
            [
                'user' => 'Dinas PUPR',
                'time' => '1 hari yang lalu',
                'message' => 'Mohon update progress untuk milestone pertama. Ada meeting dengan stakeholder minggu depan.',
                'likes' => 2
            ]
        ];

        // Activity data
        $activities = [
            [
                'icon' => 'tasks',
                'message' => 'Task "Backend API Development" dipindah ke In Progress',
                'time' => '1 jam yang lalu'
            ],
            [
                'icon' => 'check-circle',
                'message' => 'Task "Project Setup" diselesaikan',
                'time' => '3 jam yang lalu'
            ],
            [
                'icon' => 'comment',
                'message' => 'Diskusi baru dimulai oleh Dr. Andri',
                'time' => '2 jam yang lalu'
            ],
            [
                'icon' => 'user-plus',
                'message' => 'Badan Lingkungan bergabung ke proyek',
                'time' => '1 hari yang lalu'
            ],
            [
                'icon' => 'file-alt',
                'message' => 'Dokumentasi requirements telah diupload',
                'time' => '2 hari yang lalu'
            ]
        ];

        return view('kolaborasi.show', compact('kolaborasi', 'tasks', 'discussions', 'activities'));
    }

    public function create()
    {
        return view('kolaborasi.create');
    }

    public function store(Request $request)
    {
        // Store logic here - akan diimplementasi nanti
        return redirect()->route('kolaborasi.index')->with('success', 'Kolaborasi berhasil dibuat!');
    }

    public function ideIndex()
    {
        $ideKolaborasi = [
            [
                'id' => 1,
                'judul' => 'Smart Parking System',
                'deskripsi' => 'Sistem parkir pintar untuk area perkotaan menggunakan sensor IoT',
                'pemilik' => 'Diskominfo Kota',
                'kategori' => 'Smart City',
                'vote' => 15,
                'vote_progress' => 75,
                'vote_target' => 20,
                'tanggal' => '2024-10-15',
                'estimasi_waktu' => '6-12 bulan',
                'comments' => 8,
                'status' => 'open'
            ],
            [
                'id' => 2,
                'judul' => 'Aplikasi Laporan Pengaduan Masyarakat',
                'deskripsi' => 'Platform digital untuk pengaduan dan aspirasi masyarakat dengan tracking system',
                'pemilik' => 'Dinas Komunikasi',
                'kategori' => 'Layanan Publik',
                'vote' => 23,
                'vote_progress' => 100,
                'vote_target' => 20,
                'tanggal' => '2024-10-10',
                'estimasi_waktu' => '3-6 bulan',
                'comments' => 15,
                'status' => 'approved'
            ],
            [
                'id' => 3,
                'judul' => 'Sistem Monitoring Kualitas Air Sungai',
                'deskripsi' => 'Real-time monitoring kualitas air sungai menggunakan sensor multiparameter',
                'pemilik' => 'Badan Lingkungan Hidup',
                'kategori' => 'Lingkungan',
                'vote' => 8,
                'vote_progress' => 40,
                'vote_target' => 20,
                'tanggal' => '2024-10-20',
                'estimasi_waktu' => '12+ bulan',
                'comments' => 5,
                'status' => 'open'
            ],
            [
                'id' => 4,
                'judul' => 'Digital Marketplace UMKM Lokal',
                'deskripsi' => 'Platform e-commerce khusus untuk produk UMKM daerah',
                'pemilik' => 'Dinas Perdagangan',
                'kategori' => 'Ekonomi',
                'vote' => 12,
                'vote_progress' => 60,
                'vote_target' => 20,
                'tanggal' => '2024-10-18',
                'estimasi_waktu' => '6-12 bulan',
                'comments' => 6,
                'status' => 'open'
            ],
            [
                'id' => 5,
                'judul' => 'Sistem Telemedicine Terintegrasi',
                'deskripsi' => 'Platform konsultasi kesehatan online dengan rumah sakit',
                'pemilik' => 'Dinas Kesehatan',
                'kategori' => 'Kesehatan',
                'vote' => 18,
                'vote_progress' => 90,
                'vote_target' => 20,
                'tanggal' => '2024-10-12',
                'estimasi_waktu' => '3-6 bulan',
                'comments' => 12,
                'status' => 'approved'
            ],
            [
                'id' => 6,
                'judul' => 'E-Learning Platform untuk Sekolah',
                'deskripsi' => 'Sistem pembelajaran online dengan konten lokal',
                'pemilik' => 'Dinas Pendidikan',
                'kategori' => 'Pendidikan',
                'vote' => 9,
                'vote_progress' => 45,
                'vote_target' => 20,
                'tanggal' => '2024-10-22',
                'estimasi_waktu' => '6-12 bulan',
                'comments' => 4,
                'status' => 'open'
            ]
        ];

        return view('kolaborasi.ide.index', compact('ideKolaborasi'));
    }

    public function ideCreate()
    {
        return view('kolaborasi.ide.create');
    }

    public function ideStore(Request $request)
    {
        // Store logic for new idea - akan diimplementasi nanti
        return redirect()->route('kolaborasi.ide.index')->with('success', 'Ide berhasil diajukan!');
    }

    public function voteIdea($id, Request $request)
    {
        // Voting logic - akan diimplementasi nanti
        return response()->json([
            'success' => true,
            'voted' => true,
            'newCount' => rand(16, 25) // dummy data
        ]);
    }

    // TAMBAHAN: Method untuk edit dan update
    public function edit($id)
    {
        // Data dummy untuk edit
        $kolaborasi = [
            'id' => $id,
            'judul' => 'Sistem IoT Monitoring Banjir',
            'deskripsi' => 'Pengembangan sistem real-time monitoring ketinggian air sungai',
            'kategori' => 'Teknologi',
            'deadline' => '2024-12-31',
            'status' => 'active'
        ];

        return view('kolaborasi.edit', compact('kolaborasi'));
    }

    public function update(Request $request, $id)
    {
        // Update logic - akan diimplementasi nanti
        return redirect()->route('kolaborasi.show', $id)->with('success', 'Kolaborasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        // Delete logic - akan diimplementasi nanti
        return redirect()->route('kolaborasi.index')->with('success', 'Kolaborasi berhasil dihapus!');
    }
}