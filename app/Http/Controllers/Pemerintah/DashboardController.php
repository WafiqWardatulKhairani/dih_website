<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use App\Models\OpdProgram;
use App\Models\OpdInnovation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ========== PROGRAM PROGRESS CALCULATION ==========
        $averageProgramProgress = OpdProgram::where('status', 'ongoing')->avg('progress') ?? 0;
        
        // ========== INNOVATION IMPACT CALCULATION ==========
        $innovationImpact = $this->calculateInnovationImpact();
        
        // ========== PROGRAM STATUS DISTRIBUTION ==========
        $programStatus = $this->getProgramStatusDistribution();
        
        // ========== INNOVATION CATEGORIES ==========
        $innovationCategories = $this->getInnovationCategories();
        
        // ========== QUICK STATS ==========
        $programStats = [
            'active_programs' => OpdProgram::where('status', 'ongoing')->count(),
            'total_innovations' => OpdInnovation::count(),
            'active_collaborations' => $this->calculateActiveCollaborations(),
            'active_opd' => $this->calculateActiveOPD()
        ];
        
        // ========== RECENT ACHIEVEMENTS ==========
        $recentAchievements = $this->getRecentAchievements();
        
        // ========== UPCOMING DEADLINES ==========
        $upcomingDeadlines = $this->getUpcomingDeadlines();
        
        return view('pemerintah.index', compact(
            'averageProgramProgress', 
            'innovationImpact',
            'programStatus',
            'innovationCategories', 
            'programStats',
            'recentAchievements',
            'upcomingDeadlines'
        ));
    }
    
    /**
     * Calculate Innovation Impact dengan multiple factors
     */
    private function calculateInnovationImpact()
    {
        $totalInnovations = OpdInnovation::count();
        if ($totalInnovations === 0) return 0;

        $score = 0;
        $maxPossibleScore = 100; // Total weight = 100%

        // Factor 1: Technology Readiness Level - 40%
        $highTRLCount = OpdInnovation::where('technology_readiness_level', '>=', 7)->count();
        $trlScore = ($highTRLCount / $totalInnovations) * 40;
        $score += $trlScore;

        // Factor 2: Implementation Status - 30%
        $implementedCount = OpdInnovation::whereIn('status', ['implemented', 'completed'])->count();
        $statusScore = ($implementedCount / $totalInnovations) * 30;
        $score += $statusScore;

        // Factor 3: Documentation Completeness - 20%
        $completeDocsCount = OpdInnovation::where(function($query) {
            $query->whereNotNull('document_path')
                  ->orWhereNotNull('video_url')
                  ->orWhereNotNull('image');
        })->count();
        $docsScore = ($completeDocsCount / $totalInnovations) * 20;
        $score += $docsScore;

        // Factor 4: Contact Information - 10%
        $withContactCount = OpdInnovation::whereNotNull('contact')->count();
        $contactScore = ($withContactCount / $totalInnovations) * 10;
        $score += $contactScore;

        return round($score);
    }
    
    /**
     * Get program status distribution
     */
    private function getProgramStatusDistribution()
    {
        $statusCounts = OpdProgram::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        return [
            'Berjalan' => $statusCounts['ongoing'] ?? 0,
            'Perencanaan' => $statusCounts['planning'] ?? 0,
            'Selesai' => $statusCounts['completed'] ?? 0,
            'Tertunda' => $statusCounts['pending'] ?? 0,
        ];
    }
    
    /**
     * Get innovation categories distribution
     */
    private function getInnovationCategories()
    {
        return OpdInnovation::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();
    }
    
    /**
     * Calculate active collaborations
     */
    private function calculateActiveCollaborations()
    {
        // Hitung inovasi yang sedang dalam tahap kolaborasi
        return OpdInnovation::whereIn('status', ['in_progress', 'implemented'])
            ->orWhere('technology_readiness_level', '>=', 5)
            ->count();
    }
    
    /**
     * Calculate unique OPD
     */
    private function calculateActiveOPD()
    {
        $opdFromPrograms = OpdProgram::distinct()->pluck('opd_name')->count();
        $opdFromInnovations = OpdInnovation::distinct()->pluck('institution')->count();
        
        return max($opdFromPrograms, $opdFromInnovations);
    }
    
    /**
     * Get recent achievements
     */
    private function getRecentAchievements()
    {
        $smartCityProgress = OpdProgram::where('title', 'like', '%Smart City%')->value('progress') ?? 0;
        $certifiedInnovations = OpdInnovation::where('technology_readiness_level', '>=', 8)->count();
        
        return [
            [
                'achievement' => "Program Smart City mencapai {$smartCityProgress}% progress",
                'source' => 'Dinas Kominfo',
                'time' => 'Hari ini',
                'icon' => '🏆'
            ],
            [
                'achievement' => "{$certifiedInnovations} inovasi tersertifikasi nasional",
                'source' => 'Tim Inovasi', 
                'time' => '2 hari lalu',
                'icon' => '⭐'
            ],
            [
                'achievement' => 'Kolaborasi dengan ' . $this->calculateActiveCollaborations() . ' mitra',
                'source' => 'Tim Kolaborasi',
                'time' => '1 minggu lalu',
                'icon' => '🤝'
            ],
            [
                'achievement' => $this->calculateActiveOPD() . ' OPD aktif di platform',
                'source' => 'Admin System',
                'time' => '2 minggu lalu', 
                'icon' => '👥'
            ]
        ];
    }
    
    /**
     * Get upcoming deadlines
     */
    private function getUpcomingDeadlines()
    {
        $upcomingPrograms = OpdProgram::where('end_date', '>=', now())
            ->where('end_date', '<=', now()->addDays(30))
            ->orderBy('end_date')
            ->get();
            
        $deadlines = [];
        
        foreach ($upcomingPrograms as $program) {
            $daysLeft = now()->diffInDays($program->end_date);
            
            $priority = 'low';
            if ($daysLeft <= 3) $priority = 'high';
            elseif ($daysLeft <= 7) $priority = 'medium';
            
            $deadlines[] = [
                'task' => $program->title,
                'deadline' => $daysLeft == 0 ? 'Hari ini' : ($daysLeft . ' hari lagi'),
                'priority' => $priority
            ];
        }
        
        // Fallback data
        if (empty($deadlines)) {
            return [
                ['task' => 'Laporan Triwulan IV', 'deadline' => '3 hari lagi', 'priority' => 'high'],
                ['task' => 'Evaluasi Program Digital', 'deadline' => '1 minggu lagi', 'priority' => 'high'],
                ['task' => 'Rapat Koordinasi OPD', 'deadline' => '2 minggu lagi', 'priority' => 'medium'],
                ['task' => 'Pengajuan Anggaran 2024', 'deadline' => '3 minggu lagi', 'priority' => 'medium']
            ];
        }
        
        return $deadlines;
    }
    
    /**
     * API endpoint untuk chart data
     */
    public function getChartData()
    {
        $monthlyData = OpdProgram::selectRaw('MONTH(created_at) as month, COUNT(*) as count, AVG(progress) as avg_progress')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        return response()->json([
            'months' => $monthlyData->pluck('month'),
            'programs' => $monthlyData->pluck('count'), 
            'progress' => $monthlyData->pluck('avg_progress')
        ]);
    }
}