<?php
namespace App\Http\Controllers;

use App\Models\OpdProgram;
use App\Models\OpdInnovation;
use App\Models\AcademicInnovation;
use App\Models\User;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil 5 program terbaru dari opd_programs
        $programs = OpdProgram::where('status', 'active')
            ->orWhere('status', 'ongoing')
            ->orWhere('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        // Ambil inovasi dari kedua tabel dengan status yang sesuai
        $opdInnovations = OpdInnovation::where(function($query) {
                $query->where('status', 'publication') // Sesuaikan dengan data di tabel
                      ->orWhere('status', 'published')
                      ->orWhere('status', 'ready')
                      ->orWhere('status', 'review'); // Tambahkan status review juga
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(function($item) {
                return (object)[
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'category' => $item->category,
                    'status' => $item->status,
                    'image' => $item->image,
                    'institution' => $item->institution,
                    'technology_readiness_level' => $item->technology_readiness_level,
                    'created_at' => $item->created_at,
                    'type' => 'opd'
                ];
            });

        $academicInnovations = AcademicInnovation::where(function($query) {
                $query->where('status', 'published')
                      ->orWhere('status', 'publication')
                      ->orWhere('status', 'ready');
            })
            ->latest()
            ->take(5)
            ->get()
            ->map(function($item) {
                return (object)[
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->abstract ?? $item->description,
                    'category' => $item->category,
                    'status' => $item->status,
                    'image' => $item->image_path,
                    'institution' => $item->institution,
                    'technology_readiness_level' => $item->technology_readiness_level,
                    'created_at' => $item->created_at,
                    'type' => 'academic'
                ];
            });

        // Gabungkan dan ambil 5 teratas
        $allInnovations = $opdInnovations->merge($academicInnovations)
            ->sortByDesc('created_at')
            ->take(5);

        // Debug: Cek data inovasi
        // dd($opdInnovations, $academicInnovations, $allInnovations);

        // Hitung statistik untuk ditampilkan
        $stats = [
            'opd_terdaftar' => User::where('role', 'pemerintah')->where('status', 'verified')->count(),
            'akademisi_terdaftar' => User::where('role', 'akademisi')->where('status', 'verified')->count(),
            'program_selesai' => OpdProgram::where('status', 'completed')->count(),
            'program_berjalan' => OpdProgram::where('status', 'ongoing')->count(),
            'total_inovasi' => OpdInnovation::count() + AcademicInnovation::count(),
            'inovasi_dipublikasi' => OpdInnovation::whereIn('status', ['published', 'publication', 'ready'])->count() + AcademicInnovation::whereIn('status', ['published', 'publication', 'ready'])->count()
        ];

        return view('landing.landing_page', compact('programs', 'allInnovations', 'stats'));
    }

    public function tentang()
    {
        return view('landing.tentang');
    }
}