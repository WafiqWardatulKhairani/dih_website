<?php

namespace App\Http\Controllers\Akademisi;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInnovationRequest;
use App\Models\AcademicInnovation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostInnovationController extends Controller
{
    // Tampilkan form & daftar inovasi milik akademisi (atau semua jika belum ada user id)
    public function create()
    {
        $innovations = AcademicInnovation::latest()->paginate(6);
        return view('akademisi.post_inovasi', compact('innovations'));
    }

    // Simpan data
    public function store(StoreInnovationRequest $request)
    {
        $data = $request->validated();

        // Upload image
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('innovations/images', 'public');
        }

        // Upload document
        if ($request->hasFile('document')) {
            $data['document_path'] = $request->file('document')->store('innovations/documents', 'public');
        }

        // Jika ada user auth, set user_id: optional
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        $innovation = AcademicInnovation::create($data);

        return redirect()
            ->route('akademisi.post_inovasi.create')
            ->with('success', 'Inovasi berhasil disimpan. Status: ' . $innovation->status);
    }

    // Lihat detail (opsional)
    public function show(AcademicInnovation $innovation)
    {
        return view('akademisi.innovations.show', compact('innovation'));
    }

    // (Tambahan: edit/update/destroy) — jika perlu bisa ditambahkan
}
