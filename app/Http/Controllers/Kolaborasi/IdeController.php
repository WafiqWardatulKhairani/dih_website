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

        DB::transaction(function() use ($request, $user, $innovation, $documentPath, $imagePath, &$kolaborasi) {
            // Simpan ide kolaborasi
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

            // Tambahkan pengaju sebagai leader kolaborasi
            $kolaborasi->members()->create([
                'user_id' => $user->id,
                'role' => 'leader',
                'status' => 'active',
            ]);
        });

        return redirect()
            ->route('kolaborasi.ide.show', $kolaborasi->id)
            ->with('success', 'Ide kolaborasi berhasil dibuat.');
    }

    // =========================================================
    // 🔹 DETAIL IDE KOLABORASI
    // =========================================================
    public function show($id)
    {
        $kolaborasi = KolaborasiIde::with([
            'members.user',
            'tasks.assignee',
            'documents.uploader',
            'reviews.reviewer',
        ])->findOrFail($id);

        $user = Auth::user();

        $academicOwner = AcademicInnovation::with('user')->find($kolaborasi->innovation_id);
        $opdOwner = OpdInnovation::with('user')->find($kolaborasi->innovation_id);
        $pemilikIde = $academicOwner?->user ?? $opdOwner?->user ?? null;

        $leader = $kolaborasi->members->firstWhere('role', 'leader');

        $isLeader = $leader?->user_id === $user->id;
        $isPemilikIde = $pemilikIde?->id === $user->id;
        $isAnggota = $kolaborasi->members->where('user_id', $user->id)->count() > 0;

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
    // 🔹 EDIT IDE KOLABORASI
    // =========================================================
    public function edit($id)
    {
        $kolaborasi = KolaborasiIde::findOrFail($id);

        $userId = Auth::id();
        $leader = $kolaborasi->members()->where('role', 'leader')->first();

        if ($leader?->user_id !== $userId) {
            return back()->with('error', 'Anda Bukan Pengaju Kolaborasi.');
        }

        return view('kolaborasi.ide.edit', compact('kolaborasi'));
    }

    // =========================================================
    // 🔹 UPDATE IDE KOLABORASI
    // =========================================================
    public function update(Request $request, $id)
    {
        $kolaborasi = KolaborasiIde::findOrFail($id);
        $userId = Auth::id();
        $leader = $kolaborasi->members()->where('role', 'leader')->first();

        if ($leader?->user_id !== $userId) {
            return back()->with('error', 'Anda Bukan Pengaju Kolaborasi.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'estimated_duration' => 'nullable|string|max:255',
            'document' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xlsx,xls,zip|max:5120',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        DB::transaction(function() use ($request, $kolaborasi) {
            if ($request->hasFile('document')) {
                if ($kolaborasi->dokumen_path && Storage::disk('public')->exists($kolaborasi->dokumen_path)) {
                    Storage::disk('public')->delete($kolaborasi->dokumen_path);
                }
                $kolaborasi->dokumen_path = $request->file('document')->store('dokumen_kolaborasi', 'public');
            }

            if ($request->hasFile('cover_image')) {
                if ($kolaborasi->image_path && Storage::disk('public')->exists($kolaborasi->image_path)) {
                    Storage::disk('public')->delete($kolaborasi->image_path);
                }
                $kolaborasi->image_path = $request->file('cover_image')->store('gambar_kolaborasi', 'public');
            }

            $kolaborasi->update([
                'judul' => $request->title,
                'deskripsi_singkat' => $request->description,
                'estimasi_waktu' => $request->estimated_duration,
            ]);
        });

        return redirect()
            ->route('kolaborasi.ide.show', $kolaborasi->id)
            ->with('success', 'Ide kolaborasi berhasil diperbarui.');
    }

    // =========================================================
    // 🔹 HAPUS IDE KOLABORASI
    // =========================================================
    public function destroy($id)
    {
        $kolaborasi = KolaborasiIde::findOrFail($id);
        $userId = Auth::id();
        $leader = $kolaborasi->members()->where('role', 'leader')->first();

        if ($leader?->user_id !== $userId) {
            return back()->with('error', 'Anda Bukan Pengaju Kolaborasi.');
        }

        DB::transaction(function() use ($kolaborasi) {
            if ($kolaborasi->dokumen_path && Storage::disk('public')->exists($kolaborasi->dokumen_path)) {
                Storage::disk('public')->delete($kolaborasi->dokumen_path);
            }

            if ($kolaborasi->image_path && Storage::disk('public')->exists($kolaborasi->image_path)) {
                Storage::disk('public')->delete($kolaborasi->image_path);
            }

            $kolaborasi->delete();
        });

        return redirect()
            ->route('kolaborasi.index')
            ->with('success', 'Ide kolaborasi telah dihapus.');
    }

    // =========================================================
    // 🔹 JOIN KOLABORASI
    // =========================================================
    public function join($id)
    {
        $kolaborasi = KolaborasiIde::findOrFail($id);
        $userId = Auth::id();

        $alreadyMember = KolaborasiMember::where('kolaborasi_id', $id)
                            ->where('user_id', $userId)
                            ->exists();

        if ($alreadyMember) {
            return back()->with('info', 'Anda sudah tergabung atau menunggu persetujuan.');
        }

        KolaborasiMember::create([
            'kolaborasi_id' => $id,
            'user_id' => $userId,
            'role' => 'member',
            'status' => 'pending', // menunggu approval leader
        ]);

        return back()->with('success', 'Permintaan bergabung berhasil dikirim. Tunggu persetujuan leader.');
    }

    // =========================================================
    // 🔹 APPROVE KOLABORASI VIA AJAX (SweetAlert)
    // =========================================================
    public function approveAjax($id)
    {
        $kolaborasi = KolaborasiIde::with('members')->findOrFail($id);

        $userId = Auth::id();
        $isPemilikIde = AcademicInnovation::where('id', $kolaborasi->innovation_id)
                ->where('user_id', $userId)
                ->exists()
            || OpdInnovation::where('id', $kolaborasi->innovation_id)
                ->where('user_id', $userId)
                ->exists();

        if (!$isPemilikIde) {
            return response()->json(['status' => 'error', 'message' => 'Anda Bukan Pengaju Kolaborasi.'], 403);
        }

        $totalAnggota = $kolaborasi->members->count();
        if ($totalAnggota < 3) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kolaborasi belum bisa diaktifkan karena anggota kurang dari 3.'
            ], 400);
        }

        try {
            DB::transaction(function () use ($kolaborasi, $userId) {
                $kolaborasi->update([
                    'is_active' => true,
                    'reviewed_at' => now(),
                    'reviewed_by' => $userId,
                ]);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Kolaborasi telah disetujui dan diaktifkan.'
            ]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyetujui kolaborasi.'
            ], 500);
        }
    }
}
