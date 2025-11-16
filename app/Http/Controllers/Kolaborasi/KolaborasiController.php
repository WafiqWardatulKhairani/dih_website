<?php

namespace App\Http\Controllers\Kolaborasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KolaborasiIde;
use App\Models\AcademicInnovation;
use App\Models\OpdInnovation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class KolaborasiController extends Controller
{
    public function __construct()
    {
        // Halaman publik tetap bisa diakses tanpa login
        $this->middleware('auth')->except(['index', 'detail']);
    }

    // ============================================================
    // 🔹 INDEX (Daftar Kolaborasi Publik)
    // ============================================================
    public function index(Request $request)
    {
        try {
            Log::info('Akses halaman kolaborasi oleh ' . (Auth::check() ? 'user_id=' . Auth::id() : 'guest'));

            $search = trim($request->input('search', ''));

            $query = KolaborasiIde::with(['owner'])
                ->orderBy('created_at', 'desc');

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('deskripsi_singkat', 'like', "%{$search}%")
                      ->orWhereHas('owner', function ($sub) use ($search) {
                          $sub->where('name', 'like', "%{$search}%");
                      });
                });
            }

            $kolaborasis = $query->paginate(9)->appends($request->query());

            // ==================================================
            // 🔥 Gunakan method aggregate di model
            // ==================================================
            $kolaborasis->getCollection()->each(function ($k) {
                $k->setAttribute('members_count', $k->activeMembersCount());
                $k->setAttribute('progress', $k->progressPercent());
            });

            return view('kolaborasi.index', compact('kolaborasis', 'search'));

        } catch (\Throwable $e) {
            Log::error('Error di KolaborasiController@index: ' . $e->getMessage());

            // fallback paginator kosong
            $kolaborasis = new LengthAwarePaginator([], 0, 9, 1, [
                'path' => Paginator::resolveCurrentPath(),
            ]);

            $errorMessage = 'Terjadi kesalahan saat memuat data. Silakan coba lagi nanti.';
            return view('kolaborasi.index', compact('kolaborasis', 'search', 'errorMessage'));
        }
    }

    // ============================================================
    // 🔹 DETAIL (Detail Kolaborasi Publik)
    // ============================================================
    public function detail($id)
    {
        try {
            Log::info('Akses detail kolaborasi_id=' . $id . ' oleh ' . (Auth::check() ? 'user_id=' . Auth::id() : 'guest'));

            $kolaborasi = KolaborasiIde::with([
                'owner',
                'members.user',
                'tasks'
            ])->findOrFail($id);

            // Tambahkan attribute aggregate
            $kolaborasi->setAttribute('members_count', $kolaborasi->activeMembersCount());
            $kolaborasi->setAttribute('progress', $kolaborasi->progressPercent());

            $user = Auth::user();
            $isOwner = $isMember = $isLeader = false;

            if ($user) {
                // Cek ownership
                $isAcademicOwner = AcademicInnovation::where('id', $kolaborasi->innovation_id)
                    ->where('user_id', $user->id)
                    ->exists();

                $isOpdOwner = OpdInnovation::where('id', $kolaborasi->innovation_id)
                    ->where('user_id', $user->id)
                    ->exists();

                $isOwner = $isAcademicOwner || $isOpdOwner;

                // Cek anggota aktif & leader
                $memberRecord = $kolaborasi->members()
                    ->where('user_id', $user->id)
                    ->where('status', 'active')
                    ->first();

                if ($memberRecord) {
                    $isMember = true;
                    $isLeader = $memberRecord->role === 'leader';
                }
            }

            return view('kolaborasi.index-detail', compact(
                'kolaborasi',
                'isOwner',
                'isMember',
                'isLeader'
            ));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Kolaborasi tidak ditemukan: kolaborasi_id={$id}");
            return redirect()->route('kolaborasi.index')->with('error', 'Kolaborasi tidak ditemukan.');

        } catch (\Throwable $e) {
            Log::error('Error di KolaborasiController@detail: ' . $e->getMessage());
            return redirect()->route('kolaborasi.index')->with('error', 'Terjadi kesalahan saat memuat detail kolaborasi.');
        }
    }
}
