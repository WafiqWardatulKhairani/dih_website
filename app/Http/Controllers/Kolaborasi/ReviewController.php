<?php

namespace App\Http\Controllers\Kolaborasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KolaborasiReview;
use App\Models\KolaborasiMember;
use App\Models\KolaborasiTask;
use App\Models\KolaborasiIde; // <-- tambahkan model

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar review kolaborasi
     */
    public function index($kolaborasi_id)
    {
        $user = Auth::user();
        $role = $this->getUserRole($kolaborasi_id, $user->id);

        // Ambil judul kolaborasi dari tabel kolaborasi_ideas
        $kolaborasi = KolaborasiIde::findOrFail($kolaborasi_id);
        $kolaborasi_judul = $kolaborasi->judul;

        // Ambil semua anggota kolaborasi
        $members = KolaborasiMember::with('user')
            ->where('kolaborasi_id', $kolaborasi_id)
            ->get();

        // Ambil semua task terkait kolaborasi
        $tasks = KolaborasiTask::where('kolaborasi_id', $kolaborasi_id)
            ->with('assignee')
            ->get();

        // Ambil semua review yang sudah ada
        $reviews = KolaborasiReview::where('kolaborasi_id', $kolaborasi_id)->get();

        // Ambil pemilik ide inovasi (leader)
        $ownerMember = $members->firstWhere('role', 'leader');
        $kolaborasi_owner_id = $ownerMember->user_id ?? null;
        $kolaborasi_owner_name = $ownerMember->user->name ?? null;

        // Pastikan setiap task memiliki review
        foreach ($tasks as $task) {
            $existingReview = $reviews->firstWhere('kolaborasi_task_id', $task->id);
            if (!$existingReview) {
                $review = new KolaborasiReview();
                $review->kolaborasi_id = $kolaborasi_id;
                $review->kolaborasi_task_id = $task->id;
                $review->user_id = $task->assignee_id ?? $kolaborasi_owner_id;
                $review->reviewer_id = $user->id;
                $review->rating = 0;
                $review->komentar = '';
                $review->save();
                $reviews->push($review);
            }
        }

        return view('kolaborasi.reviews.index', compact(
            'tasks',
            'reviews',
            'role',
            'kolaborasi_id',
            'kolaborasi_judul',  // <-- kirim ke view
            'kolaborasi_owner_id',
            'kolaborasi_owner_name'
        ));
    }

    /**
     * Simpan review baru
     */
    public function store(Request $request, $kolaborasi_id)
    {
        $user = Auth::user();
        $role = $this->getUserRole($kolaborasi_id, $user->id);

        if ($role !== 'Pengaju Kolaborasi') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses menambahkan review.');
        }

        $data = $request->validate([
            'review_id' => 'required|exists:kolaborasi_reviews,id',
            'rating' => 'nullable|integer|min:0|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $review = KolaborasiReview::findOrFail($data['review_id']);
        $review->update([
            'rating' => $data['rating'] ?? $review->rating,
            'komentar' => $data['komentar'] ?? $review->komentar,
        ]);

        return redirect()->back()->with('success', 'Review berhasil disimpan.');
    }

    /**
     * Update review (PUT/PATCH)
     */
    public function update(Request $request, $review_id)
    {
        $review = KolaborasiReview::findOrFail($review_id);
        $user = Auth::user();
        $role = $this->getUserRole($review->kolaborasi_id, $user->id);

        // Hanya reviewer atau pemilik ide yang bisa update
        if ($role !== 'Pengaju Kolaborasi' && $review->reviewer_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses mengubah review ini.');
        }

        $data = $request->validate([
            'rating' => 'nullable|integer|min:0|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $data['rating'] ?? $review->rating,
            'komentar' => $data['komentar'] ?? $review->komentar,
        ]);

        return redirect()->back()->with('success', 'Review berhasil diperbarui.');
    }

    /**
     * Hapus review (reset rating & komentar)
     */
    public function destroy($review_id)
    {
        $review = KolaborasiReview::findOrFail($review_id);
        $user = Auth::user();
        $role = $this->getUserRole($review->kolaborasi_id, $user->id);

        if ($role !== 'Pengaju Kolaborasi') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses menghapus review.');
        }

        $review->update([
            'rating' => 0,
            'komentar' => '',
        ]);

        return redirect()->back()->with('success', 'Review berhasil dihapus.');
    }

    /**
     * Update rating via AJAX
     */
    public function updateRating(Request $request, $review_id)
    {
        $review = KolaborasiReview::findOrFail($review_id);
        $user = Auth::user();
        $role = $this->getUserRole($review->kolaborasi_id, $user->id);

        if ($role !== 'Pengaju Kolaborasi') {
            return response()->json(['error' => 'Tidak memiliki akses'], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:0|max:5',
        ]);

        $review->update(['rating' => $request->rating]);

        return response()->json(['success' => true]);
    }

    /**
     * Update komentar via AJAX
     */
    public function updateKomentar(Request $request, $review_id)
    {
        $review = KolaborasiReview::findOrFail($review_id);
        $user = Auth::user();
        $role = $this->getUserRole($review->kolaborasi_id, $user->id);

        if ($role !== 'Pengaju Kolaborasi') {
            return response()->json(['error' => 'Tidak memiliki akses'], 403);
        }

        $request->validate([
            'komentar' => 'nullable|string|max:1000',
        ]);

        $review->update(['komentar' => $request->komentar]);

        return response()->json(['success' => true]);
    }

    /**
     * Tentukan role user di kolaborasi
     */
    private function getUserRole($kolaborasi_id, $user_id)
    {
        $role = 'umum';
        $member = KolaborasiMember::where('kolaborasi_id', $kolaborasi_id)
            ->where('user_id', $user_id)
            ->first();

        if ($member) {
            if ($member->role === 'leader') {
                $role = 'Pengaju Kolaborasi';
            } elseif ($member->role === 'member') {
                $role = 'Anggota';
            }
        }

        return $role;
    }
}
