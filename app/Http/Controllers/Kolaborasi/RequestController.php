<?php

namespace App\Http\Controllers\Kolaborasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\KolaborasiMember;
use App\Models\KolaborasiIde;
use App\Services\KolaborasiService;

class RequestController extends Controller
{
    protected KolaborasiService $service;

    public function __construct(KolaborasiService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    // =========================================================
    // DAFTAR PERMINTAAN KOLABORASI
    // =========================================================
    /**
     * Tampilkan semua permintaan join kolaborasi yang pending.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil kolaborasi yang dimiliki user
        $kolaborasiIds = KolaborasiIde::where('user_id', $user->id)->pluck('id');

        // Ambil semua request pending untuk kolaborasi miliknya
        $requests = KolaborasiMember::with(['user', 'kolaborasi'])
            ->whereIn('kolaborasi_id', $kolaborasiIds)
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('kolaborasi.requests.index', compact('requests'));
    }

    // =========================================================
    // AJUKAN PERMINTAAN GABUNG
    // =========================================================
    /**
     * Kirim permintaan untuk bergabung ke kolaborasi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kolaborasi_id' => 'required|exists:kolaborasi_ideas,id',
        ]);

        $kolaborasi_id = $request->kolaborasi_id;
        $user_id = Auth::id();

        // Cek apakah user sudah tergabung atau sudah pernah request
        $existing = KolaborasiMember::where('kolaborasi_id', $kolaborasi_id)
            ->where('user_id', $user_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah terdaftar atau telah mengirim permintaan sebelumnya.');
        }

        try {
            DB::beginTransaction();

            KolaborasiMember::create([
                'kolaborasi_id' => $kolaborasi_id,
                'user_id' => $user_id,
                'role' => 'member',
                'status' => 'pending',
            ]);

            DB::commit();
            return back()->with('success', 'Permintaan bergabung berhasil dikirim.');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Gagal mengirim permintaan bergabung.');
        }
    }

    // =========================================================
    // TERIMA PERMINTAAN KOLABORASI
    // =========================================================
    /**
     * Setujui permintaan gabung ke kolaborasi (hanya owner).
     */
    public function approve($id)
    {
        $member = KolaborasiMember::with('kolaborasi')->findOrFail($id);
        $kolaborasi = $member->kolaborasi;

        // Validasi hak akses owner
        if ($kolaborasi->user_id !== Auth::id()) {
            return back()->with('error', 'Akses ditolak. Anda bukan pemilik kolaborasi ini.');
        }

        try {
            DB::beginTransaction();

            $member->update(['status' => 'active']);

            // Cek dan aktifkan kolaborasi jika memenuhi syarat
            $res = $this->service->checkAndActivate($kolaborasi);

            DB::commit();

            $msg = 'Permintaan kolaborasi telah disetujui.';
            if (!empty($res['activated'])) {
                $msg .= ' ' . $res['message'];
            }

            return back()->with('success', $msg);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Terjadi kesalahan saat menyetujui permintaan.');
        }
    }

    // =========================================================
    // TOLAK PERMINTAAN KOLABORASI
    // =========================================================
    /**
     * Tolak permintaan gabung kolaborasi (hanya owner).
     */
    public function reject($id)
    {
        $member = KolaborasiMember::with('kolaborasi')->findOrFail($id);
        $kolaborasi = $member->kolaborasi;

        if ($kolaborasi->user_id !== Auth::id()) {
            return back()->with('error', 'Akses ditolak. Anda bukan pemilik kolaborasi ini.');
        }

        try {
            DB::transaction(function () use ($member) {
                $member->update(['status' => 'rejected']);
            });

            return back()->with('success', 'Permintaan kolaborasi telah ditolak.');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Terjadi kesalahan saat menolak permintaan.');
        }
    }

    // =========================================================
    // HAPUS ANGGOTA ATAU PERMINTAAN
    // =========================================================
    /**
     * Hapus anggota atau request dari kolaborasi (hanya owner).
     */
    public function destroy($id)
    {
        $member = KolaborasiMember::with('kolaborasi')->findOrFail($id);
        $kolaborasi = $member->kolaborasi;

        if ($kolaborasi->user_id !== Auth::id()) {
            return back()->with('error', 'Akses ditolak. Anda bukan pemilik kolaborasi ini.');
        }

        try {
            DB::transaction(function () use ($member) {
                $member->delete();
            });

            return back()->with('success', 'Data anggota / permintaan kolaborasi telah dihapus.');
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Gagal menghapus data kolaborasi.');
        }
    }
}
