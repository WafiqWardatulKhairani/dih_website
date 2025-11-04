<?php

namespace App\Http\Controllers\Akademisi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AcademicInnovation;
use App\Models\KolaborasiIde;
use App\Models\KolaborasiMember;
use App\Models\KolaborasiTask;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $user   = Auth::user();

        // ===========================
        // STATISTIK RINGKAS
        // ===========================
        $stat = [
            'inovasi'           => AcademicInnovation::where('user_id', $userId)->count(),
            'kolaborasi_ide'    => KolaborasiIde::where('user_id', $userId)->count(),
            'kolaborasi_member' => KolaborasiMember::where('user_id', $userId)->count(),
            'kolaborasi_task'   => KolaborasiTask::whereHas('kolaborasi.members', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })->count(),
        ];

        // ===========================
        // INOVASI SAYA (terbaru)
        // ===========================
        $inovasiSaya = AcademicInnovation::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // ===========================
        // DISKUSI TERPOPULER
        // ===========================
        // Ambil inovasi dengan komentar terbanyak
        $diskusiTerpopuler = DB::table('academic_innovations')
            ->select(
                'academic_innovations.id',
                'academic_innovations.title',
                'academic_innovations.author_name',
                DB::raw('COUNT(discussion_comments.id) as comments_count'),
                DB::raw('"academic" as type') // tambahkan type untuk link route
            )
            ->leftJoin('discussion_comments', 'academic_innovations.id', '=', 'discussion_comments.innovation_id')
            ->groupBy(
                'academic_innovations.id',
                'academic_innovations.title',
                'academic_innovations.author_name'
            )
            ->orderByDesc('comments_count')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id'              => $item->id,
                    'title'           => $item->title,
                    'author_name'     => $item->author_name ?? 'Anonim',
                    'jumlah_komentar' => $item->comments_count ?? 0,
                    'type'            => $item->type,
                ];
            });

        // ===========================
        // KOLOABORASI BERJALAN
        // ===========================
        $kolaborasiBerjalan = KolaborasiMember::where('user_id', $userId)
            ->with('kolaborasi')
            ->get()
            ->pluck('kolaborasi')
            ->filter()
            ->take(10);

        // ===========================
        // KOLOABORASI YANG MASIH MENCARI ANGGOTA
        // ===========================
        $kolaborasiHiring = KolaborasiIde::select('id', 'judul', 'is_active')
            ->withCount('members')
            ->where('is_active', 0)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return (object)[
                    'id'             => $item->id,
                    'judul'          => $item->judul,
                    'jumlah_anggota' => $item->members_count ?? 0,
                ];
            });

        // ===========================
        // TREND (6 bulan terakhir)
        // ===========================
        $monthsCollection = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->subMonths($i);
        });

        $trendLabels = $monthsCollection->map(fn($dt) => $dt->format('M Y'))->toArray();

        $trendInovasi = $monthsCollection->map(function ($dt) use ($userId) {
            return AcademicInnovation::where('user_id', $userId)
                ->whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
        })->toArray();

        $trendKolaborasi = $monthsCollection->map(function ($dt) use ($userId) {
            return KolaborasiMember::where('user_id', $userId)
                ->whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
        })->toArray();

        // ===========================
        // KATEGORI INOVASI
        // ===========================
        $kategoriData = AcademicInnovation::select('category', DB::raw('count(*) as total'))
            ->where('user_id', $userId)
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $kategoriLabels = $kategoriData->pluck('category')->toArray();
        $kategoriCounts = $kategoriData->pluck('total')->toArray();

        // ===========================
        // BADGE USER
        // ===========================
        $badge = match (true) {
            $stat['inovasi'] >= 10 => 'Inovator Aktif 🌟',
            $stat['kolaborasi_member'] >= 5 => 'Kolaborator Solid 💪',
            $stat['kolaborasi_ide'] >= 3 => 'Penggagas Hebat 💡',
            default => 'Anggota Akademisi',
        };

        // ===========================
        // RETURN VIEW
        // ===========================
        return view('akademisi.index', [
            'user'               => $user,
            'stat'               => $stat,
            'inovasiSaya'        => $inovasiSaya,
            'diskusiTerpopuler'  => $diskusiTerpopuler,
            'kolaborasiBerjalan' => $kolaborasiBerjalan,
            'kolaborasiHiring'   => $kolaborasiHiring,
            'trendLabels'        => $trendLabels,
            'trendInovasi'       => $trendInovasi,
            'trendKolaborasi'    => $trendKolaborasi,
            'kategoriLabels'     => $kategoriLabels,
            'kategoriCounts'     => $kategoriCounts,
            'badge'              => $badge,
        ]);
    }
}
