<?php

namespace App\Http\Controllers;

use App\Models\KolaborasiIdea;
use App\Models\KolaborasiKeahlian;
use App\Models\KolaborasiPartner;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KolaborasiIdeaController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('subcategories')->get();
        return view('kolaborasi.create-ide', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'judul' => 'required|string|max:255|min:10',
            'deskripsi_singkat' => 'required|string|max:200|min:20',
            'latar_belakang' => 'nullable|string|min:30',
            'solusi' => 'nullable|string|min:30',
            'estimasi_waktu' => 'nullable|in:1-3,3-6,6-12,12+',
            'kompleksitas' => 'nullable|in:low,medium,high',
            'dampak' => 'nullable|string|min:20',
            'keahlian' => 'nullable|array',
            'keahlian.*' => 'string|max:100',
            'partner' => 'nullable|array',
            'partner.*' => 'string|max:100',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'agree_terms' => 'required|accepted'
        ], [
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori yang dipilih tidak valid',
            'subcategory_id.exists' => 'Subkategori yang dipilih tidak valid',
            'judul.required' => 'Judul ide wajib diisi',
            'judul.min' => 'Judul ide minimal 10 karakter',
            'deskripsi_singkat.required' => 'Deskripsi singkat wajib diisi',
            'deskripsi_singkat.min' => 'Deskripsi singkat minimal 20 karakter',
            'deskripsi_singkat.max' => 'Deskripsi singkat maksimal 200 karakter',
            'agree_terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        // Validasi tambahan: pastikan subkategori belongs to kategori
        $validator->after(function ($validator) use ($request) {
            if ($request->subcategory_id) {
                $subcategory = Subcategory::find($request->subcategory_id);
                if (!$subcategory || $subcategory->category_id != $request->category_id) {
                    $validator->errors()->add('subcategory_id', 'Subkategori tidak sesuai dengan kategori yang dipilih.');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam pengisian form.');
        }

        $validated = $validator->validated();

        try {
            DB::transaction(function () use ($validated, $request) {
                // Upload dokumen jika ada
                $dokumenPath = null;
                if ($request->hasFile('dokumen')) {
                    $dokumenPath = $this->uploadDokumen($request->file('dokumen'));
                }

                // Create idea
                $idea = KolaborasiIdea::create([
                    'user_id' => Auth::id(),
                    'category_id' => $validated['category_id'],
                    'subcategory_id' => $validated['subcategory_id'] ?? null,
                    'judul' => $validated['judul'],
                    'deskripsi_singkat' => $validated['deskripsi_singkat'],
                    'latar_belakang' => $validated['latar_belakang'] ?? null,
                    'solusi' => $validated['solusi'] ?? null,
                    'estimasi_waktu' => $validated['estimasi_waktu'] ?? null,
                    'kompleksitas' => $validated['kompleksitas'] ?? null,
                    'dampak' => $validated['dampak'] ?? null,
                    'dokumen_path' => $dokumenPath,
                    'status' => KolaborasiIdea::STATUS_SUBMITTED,
                    'submitted_at' => now(),
                ]);

                // Save keahlian dan partner
                if (!empty($validated['keahlian'])) {
                    $idea->addKeahlian($validated['keahlian']);
                }

                if (!empty($validated['partner'])) {
                    $idea->addPartner($validated['partner']);
                }

                // Log activity
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($idea)
                    ->log('mengajukan ide kolaborasi: ' . $idea->judul);
            });

            return redirect()->route('kolaborasi.index')
                ->with('success', [
                    'title' => 'Ide Berhasil Diajukan!',
                    'message' => 'Tim kami akan meninjaunya dalam 1-3 hari kerja.',
                    'icon' => 'success'
                ]);

        } catch (\Exception $e) {
            \Log::error('Error creating collaboration idea: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengajukan ide. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $idea = KolaborasiIdea::with(['keahlian', 'partner', 'category', 'subcategory'])
                ->findOrFail($id);

            if ($idea->user_id !== Auth::id() || !$idea->can_edit) {
                abort(403, 'Unauthorized action.');
            }

            $categories = Category::with('subcategories')->get();
            $currentSubcategories = $idea->category ? $idea->category->subcategories : collect();

            return view('kolaborasi.edit-ide', compact('idea', 'categories', 'currentSubcategories'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('kolaborasi.index')
                ->with('error', 'Ide tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $idea = KolaborasiIdea::findOrFail($id);

            if ($idea->user_id !== Auth::id() || !$idea->can_edit) {
                abort(403, 'Unauthorized action.');
            }

            $validator = Validator::make($request->all(), [
                'category_id' => 'required|exists:categories,id',
                'subcategory_id' => 'nullable|exists:subcategories,id',
                'judul' => 'required|string|max:255|min:10',
                'deskripsi_singkat' => 'required|string|max:200|min:20',
                'latar_belakang' => 'nullable|string|min:30',
                'solusi' => 'nullable|string|min:30',
                'estimasi_waktu' => 'nullable|in:1-3,3-6,6-12,12+',
                'kompleksitas' => 'nullable|in:low,medium,high',
                'dampak' => 'nullable|string|min:20',
                'keahlian' => 'nullable|array',
                'keahlian.*' => 'string|max:100',
                'partner' => 'nullable|array',
                'partner.*' => 'string|max:100',
                'dokumen' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            ]);

            $validator->after(function ($validator) use ($request) {
                if ($request->subcategory_id) {
                    $subcategory = Subcategory::find($request->subcategory_id);
                    if (!$subcategory || $subcategory->category_id != $request->category_id) {
                        $validator->errors()->add('subcategory_id', 'Subkategori tidak sesuai dengan kategori yang dipilih.');
                    }
                }
            });

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan dalam pengisian form.');
            }

            $validated = $validator->validated();

            DB::transaction(function () use ($idea, $validated, $request) {
                // Handle document upload
                $dokumenPath = $idea->dokumen_path;
                if ($request->hasFile('dokumen')) {
                    if ($dokumenPath) {
                        Storage::disk('public')->delete($dokumenPath);
                    }
                    $dokumenPath = $this->uploadDokumen($request->file('dokumen'));
                }

                // Update idea
                $idea->update([
                    'category_id' => $validated['category_id'],
                    'subcategory_id' => $validated['subcategory_id'] ?? null,
                    'judul' => $validated['judul'],
                    'deskripsi_singkat' => $validated['deskripsi_singkat'],
                    'latar_belakang' => $validated['latar_belakang'] ?? null,
                    'solusi' => $validated['solusi'] ?? null,
                    'estimasi_waktu' => $validated['estimasi_waktu'] ?? null,
                    'kompleksitas' => $validated['kompleksitas'] ?? null,
                    'dampak' => $validated['dampak'] ?? null,
                    'dokumen_path' => $dokumenPath,
                ]);

                // Sync keahlian dan partner
                $idea->syncKeahlian($validated['keahlian'] ?? []);
                $idea->syncPartner($validated['partner'] ?? []);

                // Log activity
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($idea)
                    ->log('memperbarui ide kolaborasi: ' . $idea->judul);
            });

            return redirect()->route('kolaborasi.show', $idea->id)
                ->with('success', [
                    'title' => 'Ide Berhasil Diperbarui!',
                    'message' => 'Perubahan pada ide kolaborasi telah disimpan.',
                    'icon' => 'success'
                ]);

        } catch (\Exception $e) {
            \Log::error('Error updating collaboration idea: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui ide. Silakan coba lagi.');
        }
    }

    /**
     * Upload document helper method
     */
    private function uploadDokumen($file)
    {
        $filename = 'idea_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('kolaborasi/dokumen', $filename, 'public');
    }

    // ... method lainnya tetap sama
}