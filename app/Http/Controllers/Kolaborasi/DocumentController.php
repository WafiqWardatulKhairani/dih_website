<?php

namespace App\Http\Controllers\Kolaborasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\KolaborasiDocument;
use App\Models\KolaborasiIde;

class DocumentController extends Controller
{
    public function index($kolaborasi_id)
    {
        $kolaborasi = KolaborasiIde::with('documents.uploader')->findOrFail($kolaborasi_id);
        return view('kolaborasi.documents.index', compact('kolaborasi'));
    }

    public function store(Request $request, $kolaborasi_id)
    {
        $request->validate([
            'file' => 'required|file|max:51200',
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string',
            'visibility' => 'nullable|in:public,member-only,owner-only',
        ]);

        $file = $request->file('file');
        $path = $file->store('public/kolaborasi_documents');

        $doc = KolaborasiDocument::create([
            'kolaborasi_id' => $kolaborasi_id,
            'title' => $request->input('title', $file->getClientOriginalName()),
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'category' => $request->input('category', 'teknis'),
            'visibility' => $request->input('visibility', 'member-only'),
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah.');
    }

    public function destroy($id)
    {
        $doc = KolaborasiDocument::findOrFail($id);
        // only owner or uploader can delete
        $kolaborasi = $doc->kolaborasi;
        if (auth()->id() !== $kolaborasi->owner_id && auth()->id() !== $doc->uploaded_by) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        // delete file storage
        if ($doc->file_path && Storage::exists($doc->file_path)) {
            Storage::delete($doc->file_path);
        }

        $doc->delete();

        return redirect()->back()->with('success', 'Dokumen dihapus.');
    }
}
