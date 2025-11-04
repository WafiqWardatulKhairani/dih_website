<?php

namespace App\Http\Controllers\Kolaborasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\KolaborasiIde;
use App\Models\KolaborasiMember;
use App\Models\User;
use App\Models\AcademicInnovation;
use App\Models\OpdInnovation;
use App\Services\KolaborasiService;

class MemberController extends Controller
{
    protected KolaborasiService $service;

    public function __construct(KolaborasiService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    // ========================= HELPERS =========================
    /**
     * Ambil array user_id pemilik ide (academic + opd) untuk satu innovation id.
     */
    protected function getInnovationOwnerIds(?int $innovationId): array
    {
        if (!$innovationId) return [];

        $academic = [];
        try {
            $academic = AcademicInnovation::where('id', $innovationId)
                ->whereNotNull('user_id')
                ->pluck('user_id')
                ->toArray();
        } catch (\Throwable $e) {
            $academic = [];
        }

        $opd = [];
        try {
            if (class_exists(OpdInnovation::class)) {
                $opd = OpdInnovation::where('id', $innovationId)
                    ->whereNotNull('user_id')
                    ->pluck('user_id')
                    ->toArray();
            }
        } catch (\Throwable $e) {
            $opd = [];
        }

        return array_values(array_unique(array_merge($academic, $opd)));
    }

    // ============================================================
    // INDEX
    // ============================================================
    public function index($kolaborasi_id)
    {
        $kolaborasi = KolaborasiIde::with(['members.user'])->findOrFail($kolaborasi_id);

        // Ambil pemilik inovasi spesifik sesuai innovation_id di kolaborasi
        $innovationId = $kolaborasi->innovation_id ?? null;
        $ownerIds = $this->getInnovationOwnerIds($innovationId);

        // Ambil User models untuk owner lists (dipakai di view)
        $academicOwners = collect();
        $opdOwners = collect();

        if (!empty($ownerIds)) {
            $owners = User::whereIn('id', $ownerIds)->get();
            // Jika ingin memisah academic/opd di view, bisa lakukan query yang lebih spesifik.
            // Untuk kompatibilitas, kita letakkan semuanya di academicOwners (view sudah menerima kedua var)
            $academicOwners = $owners;
            $opdOwners = collect(); // kosongkan atau sesuaikan bila butuh pemisahan
        }

        return view('kolaborasi.members.index', compact('kolaborasi', 'academicOwners', 'opdOwners'));
    }

    // ============================================================
    // STORE (Tambah anggota / ajukan)
    // ============================================================
    public function store(Request $request, $kolaborasi_id)
    {
        $kolaborasi = KolaborasiIde::findOrFail($kolaborasi_id);
        $userId = $request->input('user_id', Auth::id());

        if ($kolaborasi->members()->where('user_id', $userId)->exists()) {
            return back()->with('error', 'Pengguna sudah terdaftar di kolaborasi ini.');
        }

        try {
            DB::beginTransaction();

            // jika owner (pemilik record kolaborasi) yang menambah → langsung active
            $isKolaborasiOwner = Auth::id() === $kolaborasi->user_id;
            $status = $isKolaborasiOwner ? 'active' : 'pending';

            $kolaborasi->members()->create([
                'user_id' => $userId,
                'role' => 'member',
                'status' => $status,
            ]);

            $this->service->checkAndActivate($kolaborasi);

            DB::commit();

            $message = $status === 'active' ? 'Anggota berhasil ditambahkan.' : 'Permintaan bergabung dikirim (pending).';
            return back()->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan anggota: ' . $e->getMessage());
        }
    }

    // ============================================================
    // APPROVE (Setujui anggota pending)
    // ============================================================
    public function approve(Request $request, $kolaborasi_id, $member_id)
    {
        $kolaborasi = KolaborasiIde::with('members')->findOrFail($kolaborasi_id);
        $currentUser = Auth::user();

        // Ambil pemilik inovasi untuk kolaborasi ini
        $innovationId = $kolaborasi->innovation_id ?? null;
        $ownerIds = $this->getInnovationOwnerIds($innovationId);

        // Cek apakah current user adalah pemilik inovasi (dari academic/opd)
        $isInnovationOwner = in_array($currentUser->id, $ownerIds);

        // Cek apakah current user adalah pengaju kolaborasi (leader di kolaborasi_members)
        $currentMember = $kolaborasi->members()->where('user_id', $currentUser->id)->first();
        $isLeader = $currentMember && $currentMember->role === 'leader';

        // Juga izinkan jika currentUser adalah kolaborasi->user_id (jika ada konsep owner di tabel kolaborasi)
        $isKolaborasiOwner = $currentUser->id === $kolaborasi->user_id;

        $isAllowed = $isInnovationOwner || $isLeader || $isKolaborasiOwner;

        if (!$isAllowed) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menyetujui anggota.');
        }

        try {
            DB::beginTransaction();

            $member = KolaborasiMember::where('kolaborasi_id', $kolaborasi_id)
                ->where('id', $member_id)
                ->firstOrFail();

            if ($member->status === 'active') {
                return back()->with('error', 'Anggota sudah aktif.');
            }

            $member->update(['status' => 'active']);

            $this->service->checkAndActivate($kolaborasi);

            DB::commit();

            return back()->with('success');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error' . $e->getMessage());
        }
    }

    // ============================================================
    // DESTROY (Hapus anggota)
    // ============================================================
    public function destroy($kolaborasi_id, $user_id)
    {
        $kolaborasi = KolaborasiIde::with('members')->findOrFail($kolaborasi_id);
        $currentUser = Auth::user();

        $memberTarget = KolaborasiMember::where('kolaborasi_id', $kolaborasi_id)
            ->where('user_id', $user_id)
            ->first();

        if (!$memberTarget) {
            return back()->with('error', 'Anggota tidak ditemukan.');
        }

        // Ambil pemilik inovasi untuk kolaborasi ini
        $innovationId = $kolaborasi->innovation_id ?? null;
        $ownerIds = $this->getInnovationOwnerIds($innovationId);
        $isInnovationOwner = in_array($currentUser->id, $ownerIds);

        // Cek current user's role di kolaborasi (leader/member)
        $currentMember = $kolaborasi->members()->where('user_id', $currentUser->id)->first();
        $isLeader = $currentMember && $currentMember->role === 'leader';
        $isKolaborasiOwner = $currentUser->id === $kolaborasi->user_id;

        $canDelete = false;

        // Aturan:
        // - Pemilik inovasi (academic/opd owner) dapat menghapus siapa pun.
        if ($isInnovationOwner) {
            $canDelete = true;
        }

        // - Pemilik record kolaborasi (jika berbeda) juga boleh
        if ($isKolaborasiOwner) {
            $canDelete = true;
        }

        // - Leader (pengaju) boleh menghapus anggota biasa (member) — bukan owner/pengaju lain
        if ($isLeader && $memberTarget->role === 'member') {
            $canDelete = true;
        }

        // - Member boleh keluar sendiri
        if ($currentMember && $currentMember->role === 'member' && $currentUser->id === (int) $user_id) {
            $canDelete = true;
        }

        if (!$canDelete) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus anggota ini.');
        }

        try {
            DB::beginTransaction();

            $memberTarget->delete();

            // Jika kurang dari 3 aktif, nonaktifkan kolaborasi
            $activeCount = $kolaborasi->members()->where('status', 'active')->count();
            if ($activeCount < 3 && $kolaborasi->is_active) {
                $kolaborasi->update(['is_active' => false, 'status' => 'pending']);
            }

            DB::commit();
            return back()->with('success', 'Anggota berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus anggota: ' . $e->getMessage());
        }
    }
}
