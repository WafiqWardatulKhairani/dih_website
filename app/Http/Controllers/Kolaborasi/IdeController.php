<?php

namespace App\Http\Controllers\Kolaborasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\KolaborasiIde;
use App\Models\KolaborasiMember;
use App\Models\AcademicInnovation;
use App\Models\OpdInnovation;

class IdeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================================================
    // 🔹 DAFTAR IDE KOLABORASI
    // =========================================================
    public function index()
    {
        $ides = KolaborasiIde::with(['owner', 'members'])
            ->latest()
            ->paginate(12);

        // Tambahkan attribute aggregate
        $ides->getCollection()->each(function ($k) {
            $k->setAttribute('members_count', $k->activeMembersCount());
            $k->setAttribute('progress', $k->progressPercent());
        });

        return view('kolaborasi.index', compact('ides'));
    }

    // =========================================================
    // 🔹 FORM BUAT IDE BARU
    // =========================================================
    public function create(Request $request)
    {
        $innovationId = $request->query('innovation_id');

        $innovation = AcademicInnovation::find($innovationId)
            ?? OpdInnovation::find($innovationId);

        if (!$innovation) {
            return back()->with('error', 'Inovasi tidak ditemukan.');
        }

        return view('kolaborasi.ide.create', [
            'user' => Auth::user(),
            'innovationId' => $innovationId,
            'innovation' => $innovation,
        ]);
    }

    // =========================================================
    // 🔹 SIMPAN IDE BARU
    // =========================================================
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'estimated_duration' => 'nullable|string|max:255',
            'document' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xlsx,xls,zip|max:5120',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'innovation_id' => 'required|integer',
        ]);

        $user = Auth::user();

        $innovation = AcademicInnovation::find($request->innovation_id)
            ?? OpdInnovation::find($request->innovation_id);

        if (!$innovation) {
            return back()->with('error', 'Inovasi tidak ditemukan.');
        }

        $documentPath = $request->file('document')
            ? $request->file('document')->store('dokumen_kolaborasi', 'public')
            : null;

        $imagePath = $request->file('cover_image')
            ? $request->file('cover_image')->store('gambar_kolaborasi', 'public')
            : null;

        DB::beginTransaction();

        try {
            $kolaborasi = KolaborasiIde::create([
                'judul' => $request->title,
                'deskripsi_singkat' => $request->description,
                'estimasi_waktu' => $request->estimated_duration,
                'user_id' => $user->id,
                'innovation_id' => $innovation->id,
                'category' => $innovation->category ?? null,
                'subcategory' => $innovation->subcategory ?? null,
                'dokumen_path' => $documentPath,
                'image_path' => $imagePath,
                'is_active' => false,
                'submitted_at' => now(),
            ]);

            $kolaborasi->members()->create([
                'user_id' => $user->id,
                'role' => 'leader',
                'status' => 'active',
            ]);

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Gagal membuat ide kolaborasi.');
        }

        return redirect()
            ->route('kolaborasi.ide.show', $kolaborasi->id)
            ->with('success', 'Ide kolaborasi berhasil dibuat.');
    }

    // =========================================================
    // 🔹 DETAIL IDE
    // =========================================================
    public function show($id)
    {
        $kolaborasi = KolaborasiIde::with([
            'members.user',
            'tasks.assignee',
            'documents.uploader',
            'reviews.reviewer',
        ])->findOrFail($id);

        // Tambahkan attribute aggregate
        $kolaborasi->setAttribute('members_count', $kolaborasi->activeMembersCount());
        $kolaborasi->setAttribute('progress', $kolaborasi->progressPercent());

        $user = Auth::user();

        $academicOwner = AcademicInnovation::with('user')->find($kolaborasi->innovation_id);
        $opdOwner      = OpdInnovation::with('user')->find($kolaborasi->innovation_id);

        $pemilikIde = $academicOwner?->user ?? $opdOwner?->user ?? null;

        $leader = $kolaborasi->members->firstWhere('role', 'leader');

        $isLeader     = $leader?->user_id === $user->id;
        $isPemilikIde = $pemilikIde?->id === $user->id;
        $isAnggota    = $kolaborasi->members->contains('user_id', $user->id);

        return view('kolaborasi.ide.show', compact(
            'kolaborasi',
            'pemilikIde',
            'leader',
            'isLeader',
            'isPemilikIde',
            'isAnggota'
        ));
    }

    // =========================================================
    // 🔹 FORM EDIT IDE
    // =========================================================
    public function edit($id)
    {
        $kolaborasi = KolaborasiIde::findOrFail($id);

        // Cek otorisasi: hanya leader boleh edit
        $leader = $kolaborasi->members()->where('role', 'leader')->first();
        if ($leader?->user_id !== Auth::id()) {
            return back()->with('error', 'Hanya leader yang dapat mengedit ide.');
        }

        return view('kolaborasi.ide.edit', compact('kolaborasi'));
    }

    // =========================================================
    // 🔹 UPDATE IDE
    // =========================================================
    public function update(Request $request, $id)
    {
        $kolaborasi = KolaborasiIde::findOrFail($id);

        $leader = $kolaborasi->members()->where('role', 'leader')->first();
        if ($leader?->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk mengubah ide ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'estimated_duration' => 'nullable|string|max:255',
            'document' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xlsx,xls,zip|max:5120',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Upload file jika ada
        if ($request->hasFile('document')) {
            if ($kolaborasi->dokumen_path) {
                Storage::disk('public')->delete($kolaborasi->dokumen_path);
            }
            $kolaborasi->dokumen_path = $request->file('document')->store('dokumen_kolaborasi', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($kolaborasi->image_path) {
                Storage::disk('public')->delete($kolaborasi->image_path);
            }
            $kolaborasi->image_path = $request->file('cover_image')->store('gambar_kolaborasi', 'public');
        }

        $kolaborasi->update([
            'judul' => $request->title,
            'deskripsi_singkat' => $request->description,
            'estimasi_waktu' => $request->estimated_duration,
        ]);

        return redirect()
            ->route('kolaborasi.ide.show', $kolaborasi->id)
            ->with('success', 'Perubahan berhasil disimpan.');
    }

    // =========================================================
    // 🔹 HAPUS IDE
    // =========================================================
    public function destroy($id)
    {
        $kolaborasi = KolaborasiIde::findOrFail($id);

        $leader = $kolaborasi->members()->where('role', 'leader')->first();
        if ($leader?->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus ide ini.');
        }

        // Hapus file jika ada
        if ($kolaborasi->dokumen_path) {
            Storage::disk('public')->delete($kolaborasi->dokumen_path);
        }
        if ($kolaborasi->image_path) {
            Storage::disk('public')->delete($kolaborasi->image_path);
        }

        $kolaborasi->delete();

        return redirect()
            ->route('kolaborasi.index')
            ->with('success', 'Ide kolaborasi berhasil dihapus.');
    }

    // =========================================================
    // 🔹 REQUEST JOIN KOLABORASI
    // =========================================================
    public function join($id)
    {
        $kolaborasi = KolaborasiIde::findOrFail($id);
        $userId = Auth::id();

        if (!$kolaborasi->canJoin($userId)) {
            return back()->with('info', 'Anda sudah tergabung atau menunggu persetujuan.');
        }

        KolaborasiMember::create([
            'kolaborasi_id' => $id,
            'user_id'       => $userId,
            'role'          => 'member',
            'status'        => 'pending',
        ]);

        return back()->with('success', 'Permintaan bergabung dikirim.');
    }

    // =========================================================
    // 🔹 APPROVE MEMBER OLEH LEADER
    // =========================================================
    public function approveAjax($memberId)
    {
        $member = KolaborasiMember::with('kolaborasi')->findOrFail($memberId);
        $kolaborasi = $member->kolaborasi;

        $leader = $kolaborasi->members()->where('role', 'leader')->first();
        if ($leader?->user_id !== Auth::id()) {
            return response()->json(['status' => 'error', 'message' => 'Anda bukan leader.'], 403);
        }

        try {
            DB::beginTransaction();

            $member->update([
                'status' => 'active',
                'approved_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Anggota berhasil disetujui.'
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat approval.'
            ], 500);
        }
    }
}
