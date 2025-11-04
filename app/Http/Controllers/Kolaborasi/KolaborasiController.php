<?php

namespace App\Http\Controllers\Kolaborasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KolaborasiIde;
use App\Models\KolaborasiMember;
use App\Models\KolaborasiTask;
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
        // Hanya halaman publik yang bisa diakses tanpa login
        $this->middleware('auth')->except(['index', 'detail']);
    }

    // ============================================================
    // 🔹 INDEX: Daftar kolaborasi publik
    // ============================================================
    public function index(Request $request)
    {
        try {
            Log::info('Akses halaman kolaborasi oleh ' . (Auth::check() ? 'user_id=' . Auth::id() : 'guest'));

            $search = trim($request->input('search', ''));

            $query = KolaborasiIde::with(['owner'])
                ->withCount('tasks')
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

            // ✅ Hitung jumlah anggota + progress
            $kolaborasis->getCollection()->transform(function ($k) {
                // -----------------------
                // Hitung anggota
                // -----------------------
                $membersCount = $k->members()->where('status','active')->count();

                // Cek Pemilik Ide dari academic / opd innovation
                $ownerId = null;
                if ($k->innovation_type === 'academic') {
                    $ownerId = AcademicInnovation::where('id', $k->innovation_id)->value('user_id');
                } elseif ($k->innovation_type === 'opd') {
                    $ownerId = OpdInnovation::where('id', $k->innovation_id)->value('user_id');
                }

                // Tambahkan Pemilik Ide sebagai 1 anggota jika berbeda dari leader
                $leaderId = $k->members()->where('role','leader')->value('user_id');
                if ($ownerId && $ownerId != $leaderId) {
                    $membersCount += 1;
                }

                $k->members_count = $membersCount;

                // -----------------------
                // Hitung progress task
                // -----------------------
                $totalTasks = $k->tasks()->count();
                $doneTasks  = $k->tasks()->where('status', 'done')->count();
                $k->progress = $totalTasks > 0 ? ($doneTasks / $totalTasks) * 100 : 0;

                return $k;
            });

            return view('kolaborasi.index', compact('kolaborasis', 'search'));

        } catch (\Throwable $e) {
            Log::error('Error di KolaborasiController@index: ' . $e->getMessage());

            // Buat paginator kosong agar halaman tetap tampil rapi
            $kolaborasis = new LengthAwarePaginator([], 0, 9, 1, [
                'path' => Paginator::resolveCurrentPath(),
            ]);

            $errorMessage = 'Terjadi kesalahan saat memuat data. Silakan coba lagi nanti.';
            return view('kolaborasi.index', compact('kolaborasis', 'search', 'errorMessage'));
        }
    }

    // ============================================================
    // 🔹 DETAIL: Detail kolaborasi publik
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

            $user = Auth::user();
            $isOwner = false;
            $isMember = false;
            $isLeader = false;

            if ($user) {
                $isAcademicOwner = AcademicInnovation::where('id', $kolaborasi->innovation_id)
                    ->where('user_id', $user->id)
                    ->exists();

                $isOpdOwner = OpdInnovation::where('id', $kolaborasi->innovation_id)
                    ->where('user_id', $user->id)
                    ->exists();

                $isOwner = $isAcademicOwner || $isOpdOwner;

                $memberRecord = $kolaborasi->members()
                    ->where('user_id', $user->id)
                    ->where('status', 'active')
                    ->first();

                if ($memberRecord) {
                    $isMember = true;
                    $isLeader = $memberRecord->role === 'leader';
                }
            }

            return view('kolaborasi.index-detail', compact('kolaborasi', 'isOwner', 'isMember', 'isLeader'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Kolaborasi tidak ditemukan: kolaborasi_id={$id}");
            return redirect()->route('kolaborasi.index')->with('error', 'Kolaborasi tidak ditemukan.');
        } catch (\Throwable $e) {
            Log::error('Error di KolaborasiController@detail: ' . $e->getMessage());
            return redirect()->route('kolaborasi.index')->with('error', 'Terjadi kesalahan saat memuat detail kolaborasi.');
        }
    }
}
