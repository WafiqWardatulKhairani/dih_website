<?php

namespace App\Http\Controllers\Kolaborasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\KolaborasiProgress;
use App\Models\KolaborasiIde;
use App\Models\KolaborasiTask;
use App\Models\KolaborasiDocument;

class ProgressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan halaman progress kolaborasi beserta semua progress terkait user.
     */
    public function index($kolaborasi_id)
    {
        $userId = auth()->id();

        // Ambil kolaborasi beserta progress user dan tasks milik user
        $kolaborasi = KolaborasiIde::with([
            'progress' => function($q) use ($userId) {
                $q->where('user_id', $userId)->with('documents');
            },
            'tasks' => function($q) use ($userId) {
                $q->where('assigned_to', $userId);
            }
        ])->findOrFail($kolaborasi_id);

        return view('kolaborasi.progress.index', compact('kolaborasi'));
    }

    /**
     * Simpan progress baru, upload lampiran, update status tugas terkait, cegah duplikasi.
     */
    public function store(Request $request, $kolaborasi_id)
    {
        $request->validate([
            'task_id' => 'nullable|exists:kolaborasi_tasks,id',
            'deskripsi' => 'nullable|string|max:2000',
            'status' => 'nullable|in:todo,in-progress,done',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:3072',
        ]);

        $userId = auth()->id();

        // Cegah duplikasi progress per task per user
        $exists = KolaborasiProgress::where('kolaborasi_id', $kolaborasi_id)
                    ->where('user_id', $userId)
                    ->where('task_id', $request->task_id)
                    ->first();

        if ($exists) {
            return back()->with('error', 'Progress untuk task ini sudah dibuat.');
        }

        // Simpan progress
        $progress = KolaborasiProgress::create([
            'kolaborasi_id' => $kolaborasi_id,
            'user_id' => $userId,
            'task_id' => $request->task_id,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status ?? 'todo',
        ]);

        // Update status tugas terkait jika ada task_id
        if (!empty($request->task_id)) {
            $task = KolaborasiTask::find($request->task_id);
            if ($task) {
                $task->status = $request->status ?? 'todo';
                $task->save();
            }
        }

        // Upload lampiran jika ada
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $folder = "dokumen_kolaborasi/lampiran/kolaborasi_{$kolaborasi_id}";
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($folder, $filename, 'public');

            KolaborasiDocument::create([
                'kolaborasi_id' => $kolaborasi_id,
                'progress_id' => $progress->id,
                'title' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'category' => 'lampiran',
                'visibility' => 'public',
                'uploaded_by' => $userId,
            ]);
        }

        return back()->with('success', 'Progress berhasil ditambahkan dan status tugas diperbarui.');
    }

    /**
     * Hapus progress beserta lampiran terkait.
     */
    public function destroy($progress_id)
    {
        $progress = KolaborasiProgress::findOrFail($progress_id);

        if ($progress->user_id != auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus progress ini.');
        }

        // Hapus lampiran jika ada
        if ($progress->documents && $progress->documents->count()) {
            foreach ($progress->documents as $doc) {
                if (Storage::disk('public')->exists($doc->file_path)) {
                    Storage::disk('public')->delete($doc->file_path);
                }
                $doc->delete();
            }
        }

        $progress->delete();

        return back()->with('success', 'Progress berhasil dihapus.');
    }
}
