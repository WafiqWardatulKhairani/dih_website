<?php

namespace App\Http\Controllers\Akademisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

// Repository Interface
use App\Repositories\AcademicInnovationRepositoryInterface;

class InnovationController extends Controller
{
    protected AcademicInnovationRepositoryInterface $innovationRepo;

    public function __construct(AcademicInnovationRepositoryInterface $innovationRepo)
    {
        $this->middleware('auth');
        $this->innovationRepo = $innovationRepo;
    }

    // =========================================================
    // INDEX: Daftar inovasi milik user yang login
    // =========================================================
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->pluck('name')->toArray();

        // Ambil paginated innovations via repository
        $filters = [
            'q' => $request->input('q', null),
            'category' => $request->input('category', null)
        ];

        $paginatedInnovations = $this->innovationRepo
            ->paginateUserInnovations(Auth::id(), $filters, 12);

        // Daftar inovasi milik user, dikelompokkan per tahun
        $userInnovations = $this->innovationRepo
            ->getUserInnovationsGroupedByYear(Auth::id());

        // Inovasi trending publik
        $trending = $this->innovationRepo->getTrendingInnovations(6);

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
        $userInnovations = $this->innovationRepo
            ->getUserInnovationsGroupedByYear(Auth::id());

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
        $validStatuses = $this->innovationRepo->validStatuses();

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
        $data['status'] = $request->input('status') ?: $this->innovationRepo::STATUS_DRAFT;

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('gambar_inovasi', 'public');
        }

        if ($request->hasFile('document_path')) {
            $data['document_path'] = $request->file('document_path')->store('dokumen_inovasi', 'public');
        }

        $this->innovationRepo->create($data);

        return redirect()->route('akademisi.inovasi.index')
            ->with('success', 'Inovasi berhasil disimpan.');
    }

    // =========================================================
    // SHOW: Detail inovasi
    // =========================================================
    public function show($id)
    {
        $innovation = $this->innovationRepo->findById($id);

        $discussions = Discussion::where('discussionable_type', $this->innovationRepo->modelClass())
            ->where('discussionable_id', $id)
            ->with(['user', 'replies.user'])
            ->orderByDesc('created_at')
            ->paginate(5);

        $userInnovations = $this->innovationRepo
            ->getUserInnovationsGroupedByYear(Auth::id(), excludeId: $id);

        $latest = $this->innovationRepo->getTrendingInnovations(6);

        return view('akademisi.inovasi-detail', compact(
            'innovation',
            'userInnovations',
            'latest',
            'discussions'
        ));
    }

    // =========================================================
    // EDIT: Form edit inovasi
    // =========================================================
    public function edit($id)
    {
        $innovation = $this->innovationRepo->findById($id);
        
        // Authorization check - ensure user owns this innovation
        if ($innovation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::orderBy('name')->pluck('name')->toArray();
        $userInnovations = $this->innovationRepo
            ->getUserInnovationsGroupedByYear(Auth::id(), excludeId: $id);

        return view('akademisi.inovasi-edit', compact(
            'innovation',
            'categories',
            'userInnovations'
        ));
    }

    // =========================================================
    // UPDATE: Update inovasi
    // =========================================================
    public function update(Request $request, $id)
    {
        $innovation = $this->innovationRepo->findById($id);
        
        // Authorization check - ensure user owns this innovation
        if ($innovation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validStatuses = $this->innovationRepo->validStatuses();

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

        $data['status'] = $request->input('status') ?: $this->innovationRepo::STATUS_DRAFT;

        // Handle image update
        if ($request->hasFile('image_path')) {
            // Delete old image if exists
            if ($innovation->image_path && Storage::disk('public')->exists($innovation->image_path)) {
                Storage::disk('public')->delete($innovation->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('gambar_inovasi', 'public');
        }

        // Handle document update
        if ($request->hasFile('document_path')) {
            // Delete old document if exists
            if ($innovation->document_path && Storage::disk('public')->exists($innovation->document_path)) {
                Storage::disk('public')->delete($innovation->document_path);
            }
            $data['document_path'] = $request->file('document_path')->store('dokumen_inovasi', 'public');
        }

        $this->innovationRepo->update($id, $data);

        return redirect()->route('akademisi.inovasi.show', $id)
            ->with('success', 'Inovasi berhasil diperbarui.');
    }

    // =========================================================
    // DESTROY: Hapus inovasi
    // =========================================================
    public function destroy($id)
    {
        $innovation = $this->innovationRepo->findById($id);
        
        // Authorization check - ensure user owns this innovation
        if ($innovation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated files
        if ($innovation->image_path && Storage::disk('public')->exists($innovation->image_path)) {
            Storage::disk('public')->delete($innovation->image_path);
        }

        if ($innovation->document_path && Storage::disk('public')->exists($innovation->document_path)) {
            Storage::disk('public')->delete($innovation->document_path);
        }

        $this->innovationRepo->delete($id);

        return redirect()->route('akademisi.inovasi.index')
            ->with('success', 'Inovasi berhasil dihapus.');
    }
}