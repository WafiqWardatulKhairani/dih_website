<?php

namespace App\Http\Controllers\Kolaborasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KolaborasiTask;
use App\Models\KolaborasiIde;
use App\Models\AcademicInnovation;
use App\Models\OpdInnovation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================================================
    // 🔹 Dapatkan ID Pemilik Ide Inovasi
    // =========================================================
    private function getPemilikIdeId(KolaborasiIde $kolaborasi): ?int
    {
        if (!$kolaborasi || !$kolaborasi->innovation_id) {
            return null;
        }

        $academic = AcademicInnovation::find($kolaborasi->innovation_id);
        if ($academic) return $academic->user_id;

        $opd = OpdInnovation::find($kolaborasi->innovation_id);
        if ($opd) return $opd->user_id;

        return null;
    }

    // =========================================================
    // 🔹 Cek apakah user bisa mengakses kolaborasi ini
    // =========================================================
    private function userCanAccess(KolaborasiIde $kolaborasi): bool
    {
        $userId = Auth::id();
        $pemilikId = $this->getPemilikIdeId($kolaborasi);

        // Pemilik ide
        if ($pemilikId === $userId) return true;

        // Leader atau anggota aktif
        if (method_exists($kolaborasi, 'members')) {
            return $kolaborasi->members()
                ->where('user_id', $userId)
                ->whereIn('role', ['leader', 'member'])
                ->where('status', 'active')
                ->exists();
        }

        return false;
    }

    // =========================================================
    // 🔹 INDEX — Daftar semua tugas dalam kolaborasi
    // =========================================================
    public function index($kolaborasi_id)
    {
        $kolaborasi = KolaborasiIde::with(['members.user'])->findOrFail($kolaborasi_id);

        if (!$this->userCanAccess($kolaborasi)) {
            abort(403, 'Anda tidak memiliki izin untuk melihat tugas kolaborasi ini.');
        }

        // Daftar tugas
        $tasks = KolaborasiTask::with('assignee')
            ->where('kolaborasi_id', $kolaborasi_id)
            ->orderByRaw("FIELD(status, 'todo', 'in_progress', 'done')")
            ->orderBy('deadline', 'asc')
            ->get();

        // Anggota termasuk Leader + Member
        $members = $kolaborasi->members()->with('user')->get();

        // Leader (anggota dengan role = 'leader')
        $leader = $kolaborasi->members()->where('role', 'leader')->first();

        // Pemilik Ide Inovasi (owner akademik/OPD)
        $pemilikIdeId = $this->getPemilikIdeId($kolaborasi);
        $pemilikIde = $pemilikIdeId ? User::find($pemilikIdeId) : null;

        $kolaborasiTitle = $kolaborasi->title ?? 'Tanpa Judul';
        $kolaborasiId = $kolaborasi->id;

        return view('kolaborasi.tasks.index', compact(
            'kolaborasi',
            'kolaborasiId',
            'kolaborasiTitle',
            'tasks',
            'members',
            'leader',
            'pemilikIde'
        ));
    }

    // =========================================================
    // 🔹 STORE — Tambah tugas baru (Leader atau Pemilik Ide)
    // =========================================================
    public function store(Request $request, $kolaborasi_id)
    {
        $kolaborasi = KolaborasiIde::with('members')->findOrFail($kolaborasi_id);
        $pemilikId = $this->getPemilikIdeId($kolaborasi);
        $userId = Auth::id();

        $isOwner = ($pemilikId === $userId);
        $isLeader = $kolaborasi->members()
            ->where('user_id', $userId)
            ->where('role', 'leader')
            ->where('status', 'active')
            ->exists();

        if (!$isOwner && !$isLeader) {
            abort(403, 'Anda tidak memiliki izin untuk menambahkan tugas.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        $validated['kolaborasi_id'] = $kolaborasi_id;
        $validated['status'] = 'todo';

        KolaborasiTask::create($validated);

        return redirect()->back()->with('success', '✅ Tugas baru berhasil ditambahkan.');
    }

    // =========================================================
    // 🔹 UPDATE — Perbarui detail tugas
    // =========================================================
    public function update(Request $request, $id)
    {
        $task = KolaborasiTask::findOrFail($id);
        $kolaborasi = $task->kolaborasi;
        $userId = Auth::id();
        $pemilikId = $this->getPemilikIdeId($kolaborasi);

        $isOwner = ($pemilikId === $userId);
        $isLeader = $kolaborasi->members()
            ->where('user_id', $userId)
            ->where('role', 'leader')
            ->where('status', 'active')
            ->exists();
        $isAssigned = ($task->assigned_to == $userId);

        if (!$isOwner && !$isLeader && !$isAssigned) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit tugas ini.');
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
            'deadline' => 'nullable|date|after_or_equal:today',
            'status' => 'nullable|in:todo,in_progress,done',
        ]);

        $task->update($validated);

        return redirect()->back()->with('success');
    }

    // =========================================================
    // 🔹 TOGGLE STATUS — Ubah status tugas
    // =========================================================
    public function toggleStatus($id)
    {
        $task = KolaborasiTask::findOrFail($id);
        $kolaborasi = $task->kolaborasi;
        $userId = Auth::id();
        $pemilikId = $this->getPemilikIdeId($kolaborasi);

        $isOwner = ($pemilikId === $userId);
        $isLeader = $kolaborasi->members()
            ->where('user_id', $userId)
            ->where('role', 'leader')
            ->where('status', 'active')
            ->exists();
        $isAssigned = ($task->assigned_to == $userId);

        if (!$isOwner && !$isLeader && !$isAssigned) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah status tugas ini.');
        }

        $statusCycle = [
            'todo' => 'in_progress',
            'in_progress' => 'done',
            'done' => 'todo',
        ];

        $task->status = $statusCycle[$task->status] ?? 'todo';
        $task->save();

        return redirect()->back()->with('success');
    }

    // =========================================================
    // 🔹 DESTROY — Hapus tugas (Owner / Leader)
    // =========================================================
    public function destroy($id)
    {
        $task = KolaborasiTask::findOrFail($id);
        $kolaborasi = $task->kolaborasi;
        $userId = Auth::id();
        $pemilikId = $this->getPemilikIdeId($kolaborasi);

        $isOwner = ($pemilikId === $userId);
        $isLeader = $kolaborasi->members()
            ->where('user_id', $userId)
            ->where('role', 'leader')
            ->where('status', 'active')
            ->exists();

        if (!$isOwner && !$isLeader) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus tugas ini.');
        }

        $task->delete();

        return redirect()->back()->with('success', '🗑️ Tugas berhasil dihapus.');
    }
}
