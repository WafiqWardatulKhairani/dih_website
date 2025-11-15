<?php

namespace App\Http\Controllers\Akademisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicInnovation;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InnovationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // =========================================================
    // INDEX: Daftar inovasi milik user yang login
    // =========================================================
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->pluck('name')->toArray();

        // Hanya inovasi milik user login
        $query = AcademicInnovation::where('user_id', Auth::id());

        // Filter pencarian judul
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('keywords', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Pagination
        $paginatedInnovations = $query->orderByDesc('created_at')->paginate(12)->appends($request->query());

        // Daftar inovasi milik user, dikelompokkan per tahun
        $userInnovations = AcademicInnovation::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y'));

        // Inovasi trending publik (opsional)
        $trending = AcademicInnovation::where('status', AcademicInnovation::STATUS_PUBLICATION)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        // **REVISI DI SINI**: Gunakan view index, bukan form create
        return view('akademisi.inovasi_index', compact(
            'categories',
            'paginatedInnovations',
            'userInnovations',
            'trending'
        ));
    }

    // =========================================================
    // CREATE: Form tambah inovasi
    // =========================================================
    public function create()
    {
        $categories = Category::orderBy('name')->pluck('name')->toArray();

        // Sertakan juga daftar inovasi user agar sidebar tidak error
        $userInnovations = AcademicInnovation::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y'));

        return view('akademisi.inovasi', compact(
            'categories',
            'userInnovations'
        ));
    }

    // =========================================================
    // STORE: Simpan inovasi baru
    // =========================================================
    public function store(Request $request)
    {
        $validStatuses = AcademicInnovation::statuses();

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'subcategory' => ['required', 'string'],
            'author_name' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'keywords' => ['required', 'string'],
            'description' => ['required', 'string'],
            'purpose' => ['required', 'string'],
            'technology_readiness_level' => ['required', 'integer', 'between:1,9'],
            'image_path' => ['required', 'image', 'max:5120'],
            'document_path' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            'video_url' => ['nullable', 'url'],
            'contact' => ['required', 'string', 'max:255'],
            'status' => ['nullable', Rule::in($validStatuses)],
        ]);

        $data = $request->only([
            'title', 'category', 'subcategory', 'author_name', 'institution',
            'keywords', 'description', 'purpose', 'technology_readiness_level',
            'video_url', 'contact', 'status'
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = $request->input('status') ?: AcademicInnovation::STATUS_DRAFT;

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('gambar_inovasi', 'public');
        }

        if ($request->hasFile('document_path')) {
            $data['document_path'] = $request->file('document_path')->store('dokumen_inovasi', 'public');
        }

        AcademicInnovation::create($data);

        return redirect()->route('akademisi.inovasi.index')
            ->with('success', 'Inovasi berhasil disimpan.');
    }

    // =========================================================
    // SHOW: Detail inovasi
    // =========================================================
    public function show($id)
    {
        $innovation = AcademicInnovation::findOrFail($id);

        $discussions = Discussion::where('discussionable_type', AcademicInnovation::class)
            ->where('discussionable_id', $id)
            ->with(['user', 'replies.user'])
            ->orderByDesc('created_at')
            ->paginate(5);

        $userInnovations = AcademicInnovation::where('user_id', Auth::id())
            ->where('id', '!=', $id)
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y'));

        $latest = AcademicInnovation::where('status', AcademicInnovation::STATUS_PUBLICATION)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('akademisi.inovasi-detail', compact(
            'innovation',
            'userInnovations',
            'latest',
            'discussions'
        ));
    }

    // =========================================================
    // EDIT & UPDATE: Edit inovasi
    // =========================================================
    public function edit($id)
    {
        $innovation = AcademicInnovation::findOrFail($id);
        if (Auth::id() != $innovation->user_id) abort(403);

        $categories = Category::orderBy('name')->pluck('name')->toArray();

        return view('akademisi.inovasi-edit', compact(
            'innovation',
            'categories'
        ));
    }

    public function update(Request $request, $id)
    {
        $innovation = AcademicInnovation::findOrFail($id);
        if (Auth::id() != $innovation->user_id) abort(403);

        $validStatuses = AcademicInnovation::statuses();

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string'],
            'subcategory' => ['required', 'string'],
            'author_name' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'keywords' => ['required', 'string'],
            'description' => ['required', 'string'],
            'purpose' => ['required', 'string'],
            'technology_readiness_level' => ['required', 'integer', 'between:1,9'],
            'image_path' => ['nullable', 'image', 'max:5120'],
            'document_path' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'video_url' => ['nullable', 'url'],
            'contact' => ['required', 'string', 'max:255'],
            'status' => ['nullable', Rule::in($validStatuses)],
        ]);

        $data = $request->only([
            'title', 'category', 'subcategory', 'author_name', 'institution',
            'keywords', 'description', 'purpose', 'technology_readiness_level',
            'video_url', 'contact', 'status'
        ]);

        $data['status'] = $request->input('status') ?: AcademicInnovation::STATUS_DRAFT;

        if ($request->hasFile('image_path')) {
            if ($innovation->image_path && Storage::disk('public')->exists($innovation->image_path)) {
                Storage::disk('public')->delete($innovation->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('gambar_inovasi', 'public');
        }

        if ($request->hasFile('document_path')) {
            if ($innovation->document_path && Storage::disk('public')->exists($innovation->document_path)) {
                Storage::disk('public')->delete($innovation->document_path);
            }
            $data['document_path'] = $request->file('document_path')->store('dokumen_inovasi', 'public');
        }

        $innovation->update($data);

        return redirect()->route('akademisi.inovasi.show', $innovation->id)
            ->with('success', 'Inovasi berhasil diperbarui!');
    }

    // =========================================================
    // DESTROY: Hapus inovasi
    // =========================================================
    public function destroy($id)
    {
        $innovation = AcademicInnovation::findOrFail($id);
        if (Auth::id() != $innovation->user_id) abort(403);

        if ($innovation->image_path && Storage::disk('public')->exists($innovation->image_path)) {
            Storage::disk('public')->delete($innovation->image_path);
        }
        if ($innovation->document_path && Storage::disk('public')->exists($innovation->document_path)) {
            Storage::disk('public')->delete($innovation->document_path);
        }

        $innovation->delete();

        return redirect()->route('akademisi.inovasi.index')
            ->with('success', 'Inovasi berhasil dihapus.');
    }

    // =========================================================
    // SUBCATEGORIES: Ambil subkategori dari kategori tertentu
    // =========================================================
    public function subcategories(Request $request)
    {
        $categoryName = $request->query('category');

        if (!$categoryName) return response()->json([]);

        $category = Category::where('name', $categoryName)->first();
        if (!$category) return response()->json([]);

        $subs = Subcategory::where('category_id', $category->id)
            ->orderBy('name')
            ->pluck('name');

        return response()->json($subs);
    }
}
