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
use App\Models\OpdProgram;
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
        // SEMUA DATA MENGGUNAKAN ELOQUENT MODELS
        // ===========================

        // PROGRAM PEMERINTAH TERBARU
        $programPemerintah = OpdProgram::where(function($query) {
                $query->where('status', 'ongoing')
                      ->orWhere('status', 'planning');
            })
            ->select('id', 'title', 'description', 'opd_name', 'category', 'status', 'start_date', 'end_date', 'budget', 'progress', 'image', 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // INOVASI SAYA
        $inovasiSaya = AcademicInnovation::where('user_id', $userId)
            ->select('id', 'title', 'author_name', 'category', 'technology_readiness_level', 'created_at', 'image_path')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // DISKUSI TERPOPULER
        $diskusiTerpopuler = AcademicInnovation::select(
                'academic_innovations.id',
                'academic_innovations.title',
                'academic_innovations.author_name',
                'academic_innovations.category',
                'academic_innovations.created_at',
                'academic_innovations.image_path',
                DB::raw('COUNT(discussion_comments.id) as jumlah_komentar')
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
            ->orderByDesc('jumlah_komentar')
            ->limit(5)
            ->get();

        // Tambahkan custom attributes untuk diskusi
        $diskusiTerpopuler->each(function ($item) {
            $item->type = 'academic';
            $item->formatted_created_at = $this->formatDate($item->created_at, 'd M Y');
        });

        // KOLABORASI BERJALAN
        $kolaborasiBerjalan = KolaborasiIde::where(function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhereHas('members', function($q) use ($userId) {
                          $q->where('user_id', $userId);
                      });
            })
            ->where('status', 'active')
            ->select('id', 'judul', 'deskripsi', 'status', 'deadline', 'image_path', 'created_at')
            ->withCount(['members', 'tasks'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Tambahkan custom attributes untuk kolaborasi
        $kolaborasiBerjalan->each(function ($kolab) {
            $kolab->deskripsi_singkat = $kolab->deskripsi ? 
                (strlen($kolab->deskripsi) > 100 
                    ? substr($kolab->deskripsi, 0, 100) . '...' 
                    : $kolab->deskripsi) 
                : 'Tidak ada deskripsi';
            $kolab->formatted_deadline = $kolab->deadline ? $this->formatDate($kolab->deadline, 'd M Y') : null;
            $kolab->formatted_created_at = $this->formatDate($kolab->created_at, 'd M Y');
        });

        // AKTIVITAS TERBARU - Gunakan array biasa untuk menghindari masalah getKey()
        $aktivitasTerbaru = [];

        // Aktivitas dari inovasi terbaru
        $inovasiTerbaru = AcademicInnovation::where('user_id', $userId)
            ->select('id', 'title', 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($inovasiTerbaru as $inovasi) {
            $aktivitasTerbaru[] = [
                'deskripsi' => "Membuat inovasi: {$inovasi->title}",
                'waktu' => \Carbon\Carbon::parse($inovasi->created_at)->diffForHumans(),
                'timestamp' => \Carbon\Carbon::parse($inovasi->created_at)->timestamp,
                'link' => route('akademisi.inovasi.show', $inovasi->id),
            ];
        }

        // Aktivitas dari komentar terbaru
        $komentarTerbaru = DiscussionComment::where('user_id', $userId)
            ->with('innovation:id,title')
            ->select('id', 'innovation_id', 'content', 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($komentarTerbaru as $komentar) {
            $judulInovasi = $komentar->innovation->title ?? 'Tidak diketahui';
            $aktivitasTerbaru[] = [
                'deskripsi' => "Memberi komentar pada inovasi: {$judulInovasi}",
                'waktu' => \Carbon\Carbon::parse($komentar->created_at)->diffForHumans(),
                'timestamp' => \Carbon\Carbon::parse($komentar->created_at)->timestamp,
                'link' => route('forum-diskusi.detail', ['type' => 'academic', 'id' => $komentar->innovation_id]),
            ];
        }

        // Aktivitas dari kolaborasi terbaru
        $kolaborasiTerbaru = KolaborasiMember::where('user_id', $userId)
            ->with('kolaborasi:id,judul')
            ->select('id', 'kolaborasi_id', 'created_at')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        foreach ($kolaborasiTerbaru as $member) {
            $judulKolaborasi = $member->kolaborasi->judul ?? 'Tidak diketahui';
            $aktivitasTerbaru[] = [
                'deskripsi' => "Bergabung dalam kolaborasi: {$judulKolaborasi}",
                'waktu' => \Carbon\Carbon::parse($member->created_at)->diffForHumans(),
                'timestamp' => \Carbon\Carbon::parse($member->created_at)->timestamp,
                'link' => route('kolaborasi.ide.show', $member->kolaborasi_id),
            ];
        }

        // Urutkan berdasarkan timestamp dan ambil 5 terbaru
        usort($aktivitasTerbaru, function($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });
        $aktivitasTerbaru = array_slice($aktivitasTerbaru, 0, 5);

        // Jika tidak ada aktivitas, beri placeholder
        if (empty($aktivitasTerbaru)) {
            $aktivitasTerbaru = [
                [
                    'deskripsi' => 'Belum ada aktivitas terbaru',
                    'waktu' => 'Mulai berinovasi!',
                    'timestamp' => time(),
                    'link' => route('akademisi.inovasi.index'),
                ]
            ];
        }

        // ===========================
        // DATA UNTUK CHART
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

        // Trend program pemerintah seluruh user
        $trendAllProgram = $monthsCollection->map(function ($dt) {
            return OpdProgram::whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
        })->toArray();

        // Trend diskusi seluruh user
        $trendAllDiskusi = $monthsCollection->map(function ($dt) {
            return DiscussionComment::whereMonth('created_at', $dt->month)
                ->whereYear('created_at', $dt->year)
                ->count();
        })->toArray();

        // KATEGORI SELURUH USER
        try {
            $kategoriAllData = AcademicInnovation::select('category as name', DB::raw('count(*) as total'))
                ->groupBy('category')
                ->orderByDesc('total')
                ->limit(4)
                ->get();

            if ($kategoriAllData->isEmpty()) {
                $kategoriAllData = collect([
                    (object) ['name' => 'Teknologi', 'total' => 10],
                    (object) ['name' => 'Pendidikan', 'total' => 8],
                    (object) ['name' => 'Kesehatan', 'total' => 6],
                    (object) ['name' => 'Lainnya', 'total' => 4],
                ]);
            }
        } catch (\Exception $e) {
            $kategoriAllData = collect([
                (object) ['name' => 'Teknologi', 'total' => 10],
                (object) ['name' => 'Pendidikan', 'total' => 8],
                (object) ['name' => 'Kesehatan', 'total' => 6],
                (object) ['name' => 'Lainnya', 'total' => 4],
            ]);
        }

        $kategoriAllLabels = $kategoriAllData->pluck('name')->toArray();
        $kategoriAllCounts = $kategoriAllData->pluck('total')->toArray();

        // TREND USER LOGIN
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

        // KATEGORI USER LOGIN
        $kategoriMyData = AcademicInnovation::select('category', DB::raw('count(*) as total'))
            ->where('user_id', $userId)
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $kategoriMyLabels = $kategoriMyData->pluck('category')->toArray();
        $kategoriMyCounts = $kategoriMyData->pluck('total')->toArray();

        if (empty($kategoriMyLabels)) {
            $kategoriMyLabels = ['Umum'];
            $kategoriMyCounts = [1];
        }

        // BADGE USER
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
            'programPemerintah'  => $programPemerintah,
            'inovasiSaya'        => $inovasiSaya,
            'diskusiTerpopuler'  => $diskusiTerpopuler,
            'kolaborasiBerjalan' => $kolaborasiBerjalan,
            'aktivitasTerbaru'   => $aktivitasTerbaru, // Sekarang array biasa
            
            // Data chart
            'trendAllLabels'     => $trendAllLabels,
            'trendAllInovasi'    => $trendAllInovasi,
            'trendAllKolaborasi' => $trendAllKolaborasi,
            'trendAllProgram'    => $trendAllProgram,
            'trendAllDiskusi'    => $trendAllDiskusi,
            'kategoriAllLabels'  => $kategoriAllLabels,
            'kategoriAllCounts'  => $kategoriAllCounts,
            
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
}