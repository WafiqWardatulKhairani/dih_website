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
        $programs = OpdProgram::whereIn('status', ['active','ongoing','published'])
            ->latest()
            ->take(5)
            ->get();

        // Ambil 5 inovasi terbaru dari OPD
        $opdInnovations = OpdInnovation::whereIn('status', ['publication','published','ready','review'])
            ->latest()
            ->take(5)
            ->get();

        // Ambil 5 inovasi terbaru dari akademisi
        $academicInnovations = AcademicInnovation::whereIn('status', ['published','publication','ready'])
            ->latest()
            ->take(5)
            ->get();

        // Gabungkan dan urutkan berdasarkan created_at
        $allInnovations = $opdInnovations->merge($academicInnovations)
            ->sortByDesc('created_at')
            ->take(5);

        // Hitung statistik
        $stats = [
            'opd_terdaftar' => User::where('role', 'pemerintah')->where('status', 'verified')->count(),
            'akademisi_terdaftar' => User::where('role', 'akademisi')->where('status', 'verified')->count(),
            'program_selesai' => OpdProgram::where('status', 'completed')->count(),
            'program_berjalan' => OpdProgram::where('status', 'ongoing')->count(),
            'total_inovasi' => OpdInnovation::count() + AcademicInnovation::count(),
            'inovasi_dipublikasi' => OpdInnovation::whereIn('status', ['published','publication','ready'])->count() +
                                     AcademicInnovation::whereIn('status', ['published','publication','ready'])->count()
        ];

        return view('landing.landing_page', compact('programs', 'allInnovations', 'stats'));
    }

    public function tentang()
    {
        return view('landing.tentang');
    }
}
