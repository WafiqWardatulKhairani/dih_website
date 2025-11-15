<?php

namespace App\Http\Controllers\Akademisi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AcademicInnovation;
use App\Models\KolaborasiIde;
use App\Models\KolaborasiMember;
use App\Models\KolaborasiTask;
use App\Models\DiscussionComment;
use App\Models\OpdInnovation;
use App\Models\Category;
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
            'kolaborasi_aktif'  => KolaborasiMember::where('user_id', $userId)
                ->whereHas('kolaborasi', function ($q) {
                    $q->where('status', 'active');
                })->count(),
            'diskusi_diikuti'   => DiscussionComment::where('user_id', $userId)
                ->distinct('innovation_id')
                ->count('innovation_id'),
        ];

        // ===========================
        // INOVASI SAYA (terbaru)
        // ===========================
        $inovasiSaya = AcademicInnovation::where('user_id', $userId)
            ->select('id', 'title', 'author_name', 'category', 'technology_readiness_level', 'created_at', 'image_path')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($inovasi) {
                return (object) [
                    'id' => $inovasi->id,
                    'title' => $inovasi->title,
                    'author_name' => $inovasi->author_name,
                    'kategori' => $inovasi->category ?? 'Umum',
                    'category' => $inovasi->category ?? 'Umum',
                    'technology_readiness_level' => $inovasi->technology_readiness_level,
                    'image_path' => $inovasi->image_path,
                    'created_at' => $this->formatDate($inovasi->created_at),
                ];
            });

        // ===========================
        // DISKUSI TERPOPULER (dari semua user)
        // ===========================
        $diskusiTerpopuler = DB::table('academic_innovations')
            ->select(
                'academic_innovations.id',
                'academic_innovations.title',
                'academic_innovations.author_name',
                'academic_innovations.category',
                'academic_innovations.created_at',
                'academic_innovations.image_path',
                DB::raw('COUNT(discussion_comments.id) as comments_count'),
                DB::raw('"academic" as type')
            )
            ->leftJoin('discussion_comments', 'academic_innovations.id', '=', 'discussion_comments.innovation_id')
            ->groupBy(
                'academic_innovations.id',
                'academic_innovations.title',
                'academic_innovations.author_name',
                'academic_innovations.category',
                'academic_innovations.created_at',
                'academic_innovations.image_path'
            )
            ->orderByDesc('comments_count')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'id'              => $item->id,
                    'title'           => $item->title,
                    'author_name'     => $item->author_name ?? 'Anonim',
                    'category'        => $item->category ?? 'Umum',
                    'image_path'      => $item->image_path,
                    'jumlah_komentar' => $item->comments_count ?? 0,
                    'type'            => $item->type,
                    'created_at'      => $this->formatDate($item->created_at),
                ];
            });

        // ===========================
        // KOLABORASI BERJALAN
        // ===========================
        $kolaborasiBerjalan = KolaborasiMember::where('user_id', $userId)
            ->with(['kolaborasi' => function($query) {
                $query->select('id', 'judul', 'status', 'deskripsi', 'deadline', 'created_at');
            }])
            ->get()
            ->pluck('kolaborasi')
            ->filter()
            ->take(10)
            ->map(function ($kolab) {
                $deadlineFormatted = $kolab->deadline ? $this->formatDate($kolab->deadline, 'd M') : null;
                
                return (object) [
                    'id' => $kolab->id,
                    'judul' => $kolab->judul,
                    'status' => $kolab->status,
                    'deskripsi_singkat' => $kolab->deskripsi ? 
                        (strlen($kolab->deskripsi) > 100 
                            ? substr($kolab->deskripsi, 0, 100) . '...' 
                            : $kolab->deskripsi) 
                        : 'Tidak ada deskripsi',
                    'deadline' => $deadlineFormatted,
                    'jumlah_anggota' => KolaborasiMember::where('kolaborasi_id', $kolab->id)->count(),
                    'jumlah_tugas' => KolaborasiTask::where('kolaborasi_id', $kolab->id)->count(),
                    'created_at' => $this->formatDate($kolab->created_at),
                ];
            });

        // ===========================
        // PROGRESS KOLABORASI AKTIF (dengan ID untuk link)
        // ===========================
        $progressKolaborasi = KolaborasiMember::where('user_id', $userId)
            ->with(['kolaborasi' => function($query) {
                $query->select('id', 'judul', 'progress');
            }])
            ->whereHas('kolaborasi', function($q) {
                $q->where('status', 'active');
            })
            ->get()
            ->pluck('kolaborasi')
            ->filter()
            ->take(5)
            ->map(function ($kolab) {
                return (object) [
                    'id' => $kolab->id,
                    'judul' => $kolab->judul ?? 'Judul Tidak Tersedia',
                    'progress' => $kolab->progress ?? 0,
                ];
            });

        // ===========================
        // AKTIVITAS TERBARU (dengan link)
        // ===========================
        $aktivitasTerbaru = collect();

        // Aktivitas dari inovasi terbaru
        $inovasiTerbaru = AcademicInnovation::where('user_id', $userId)
            ->select('id', 'title', 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($inovasi) {
                return (object) [
                    'deskripsi' => "Membuat inovasi: {$inovasi->title}",
                    'waktu' => $this->formatDate($inovasi->created_at),
                    'timestamp' => $this->getTimestamp($inovasi->created_at),
                    'link' => route('akademisi.inovasi.show', $inovasi->id),
                ];
            });

        // Aktivitas dari komentar terbaru
        $komentarTerbaru = DiscussionComment::where('user_id', $userId)
            ->with('innovation:id,title')
            ->select('id', 'innovation_id', 'content', 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($komentar) {
                $judulInovasi = $komentar->innovation->title ?? 'Tidak diketahui';
                return (object) [
                    'deskripsi' => "Memberi komentar pada inovasi: {$judulInovasi}",
                    'waktu' => $this->formatDate($komentar->created_at),
                    'timestamp' => $this->getTimestamp($komentar->created_at),
                    'link' => route('forum-diskusi.detail', ['type' => 'academic', 'id' => $komentar->innovation_id]),
                ];
            });

        // Aktivitas dari kolaborasi terbaru
        $kolaborasiTerbaru = KolaborasiMember::where('user_id', $userId)
            ->with('kolaborasi:id,judul')
            ->select('id', 'kolaborasi_id', 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($member) {
                $judulKolaborasi = $member->kolaborasi->judul ?? 'Tidak diketahui';
                return (object) [
                    'deskripsi' => "Bergabung dalam kolaborasi: {$judulKolaborasi}",
                    'waktu' => $this->formatDate($member->created_at),
                    'timestamp' => $this->getTimestamp($member->created_at),
                    'link' => route('kolaborasi.ide.show', $member->kolaborasi_id),
                ];
            });

        // Gabungkan semua aktivitas dan urutkan berdasarkan timestamp
        $aktivitasTerbaru = $inovasiTerbaru->merge($komentarTerbaru)->merge($kolaborasiTerbaru)
            ->sortByDesc('timestamp')
            ->take(5)
            ->values();

        // Jika tidak ada aktivitas, beri placeholder
        if ($aktivitasTerbaru->isEmpty()) {
            $aktivitasTerbaru = collect([
                (object) [
                    'deskripsi' => 'Belum ada aktivitas terbaru',
                    'waktu' => 'Mulai berinovasi!',
                    'timestamp' => time(),
                    'link' => route('akademisi.inovasi.index'),
                ]
            ]);
        }

        // ===========================
        // TREND SELURUH USER (6 bulan terakhir)
        // ===========================
        $monthsCollection = collect(range(5, 0))->map(function ($i) {
            return Carbon::now()->subMonths($i);
        });

        $trendAllLabels = $monthsCollection->map(fn($dt) => $dt->format('M Y'))->toArray();

        // Trend inovasi seluruh user
        $trendAllInovasi = $monthsCollection->map(function ($dt) {
            return AcademicInnovation::whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
        })->toArray();

        // Trend kolaborasi seluruh user
        $trendAllKolaborasi = $monthsCollection->map(function ($dt) {
            return KolaborasiMember::whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
        })->toArray();

        // ===========================
        // KATEGORI SELURUH USER (query manual)
        // ===========================
        // Jika tabel categories ada dan memiliki data
        try {
            $kategoriAllData = DB::table('categories')
                ->leftJoin('academic_innovations', 'categories.name', '=', 'academic_innovations.category')
                ->leftJoin('opd_innovations', 'categories.name', '=', 'opd_innovations.category')
                ->select(
                    'categories.name',
                    DB::raw('COUNT(DISTINCT academic_innovations.id) + COUNT(DISTINCT opd_innovations.id) as total')
                )
                ->groupBy('categories.name')
                ->orderByDesc('total')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            // Fallback: ambil dari field category di academic_innovations
            $kategoriAllData = AcademicInnovation::select('category', DB::raw('count(*) as total'))
                ->groupBy('category')
                ->orderByDesc('total')
                ->limit(10)
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'name' => $item->category,
                        'total' => $item->total
                    ];
                });
        }

        $kategoriAllLabels = $kategoriAllData->pluck('name')->toArray();
        $kategoriAllCounts = $kategoriAllData->pluck('total')->toArray();

        // ===========================
        // TREND USER LOGIN (6 bulan terakhir)
        // ===========================
        $trendMyLabels = $monthsCollection->map(fn($dt) => $dt->format('M Y'))->toArray();

        $trendMyInovasi = $monthsCollection->map(function ($dt) use ($userId) {
            return AcademicInnovation::where('user_id', $userId)
                ->whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
        })->toArray();

        $trendMyKolaborasi = $monthsCollection->map(function ($dt) use ($userId) {
            return KolaborasiMember::where('user_id', $userId)
                ->whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
        })->toArray();

        // ===========================
        // KATEGORI USER LOGIN
        // ===========================
        $kategoriMyData = AcademicInnovation::select('category', DB::raw('count(*) as total'))
            ->where('user_id', $userId)
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $kategoriMyLabels = $kategoriMyData->pluck('category')->toArray();
        $kategoriMyCounts = $kategoriMyData->pluck('total')->toArray();

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
            'progressKolaborasi' => $progressKolaborasi,
            'aktivitasTerbaru'   => $aktivitasTerbaru,
            
            // Data untuk seluruh user
            'trendAllLabels'     => $trendAllLabels,
            'trendAllInovasi'    => $trendAllInovasi,
            'trendAllKolaborasi' => $trendAllKolaborasi,
            'kategoriAllLabels'  => $kategoriAllLabels,
            'kategoriAllCounts'  => $kategoriAllCounts,
            
            // Data untuk user login
            'trendMyLabels'      => $trendMyLabels,
            'trendMyInovasi'     => $trendMyInovasi,
            'trendMyKolaborasi'  => $trendMyKolaborasi,
            'kategoriMyLabels'   => $kategoriMyLabels,
            'kategoriMyCounts'   => $kategoriMyCounts,
            
            'badge'              => $badge,
        ]);
    }

    /**
     * Helper function untuk format tanggal dengan aman
     */
    private function formatDate($date, $format = 'diffForHumans')
    {
        if (!$date) {
            return 'Tidak ada tanggal';
        }

        try {
            $carbonDate = Carbon::parse($date);
            
            if ($format === 'diffForHumans') {
                return $carbonDate->diffForHumans();
            } else {
                return $carbonDate->format($format);
            }
        } catch (\Exception $e) {
            return is_string($date) ? $date : 'Tanggal tidak valid';
        }
    }

    /**
     * Helper function untuk mendapatkan timestamp dari date
     */
    private function getTimestamp($date)
    {
        if (!$date) {
            return time();
        }

        try {
            return Carbon::parse($date)->timestamp;
        } catch (\Exception $e) {
            return time();
        }
    }
}