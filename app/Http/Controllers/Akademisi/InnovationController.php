<?php

namespace App\Http\Controllers\Akademisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicInnovation;
use App\Models\Subcategory;
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
    // INDEX: daftar inovasi publik + inovasi milik user
    // =========================================================
    public function index(Request $request)
    {
        $categories = Subcategory::select('category')->distinct()->pluck('category');

        $baseQuery = AcademicInnovation::query()
            ->where('status', AcademicInnovation::STATUS_PUBLICATION);

        if ($request->filled('q')) {
            $q = $request->q;
            $baseQuery->where(function ($qb) use ($q) {
                $qb->where('title', 'like', "%{$q}%")
                   ->orWhere('description', 'like', "%{$q}%")
                   ->orWhere('keywords', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $baseQuery->where('category', $request->category);
        }

        $latest = (clone $baseQuery)->orderByDesc('created_at')->paginate(6);

        $userInnovations = AcademicInnovation::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y'));

        $trending = (clone $baseQuery)->orderByDesc('created_at')->take(6)->get();

        return view('akademisi.inovasi_index', compact(
            'categories',
            'latest',
            'userInnovations',
            'trending'
        ));
    }

    // =========================================================
    // CREATE: form posting inovasi baru
    // =========================================================
    public function create()
    {
        $categories = Subcategory::select('category')->distinct()->pluck('category');

        $yearlyInnovations = AcademicInnovation::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('Y'));

        $latest = AcademicInnovation::where('status', AcademicInnovation::STATUS_PUBLICATION)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('akademisi.inovasi', compact(
            'categories',
            'yearlyInnovations',
            'latest'
        ));
    }

    // =========================================================
    // STORE: simpan inovasi baru
    // =========================================================
    public function store(Request $request)
    {
        $validStatuses = AcademicInnovation::statuses();

        $request->validate([
            'title' => ['required','string','max:255'],
            'category' => ['required','string'],
            'subcategory' => ['required','string'],
            'author_name' => ['required','string','max:255'],
            'institution' => ['required','string','max:255'],
            'keywords' => ['required','string'],
            'description' => ['required','string'],
            'purpose' => ['required','string'],
            'technology_readiness_level' => ['required','integer','between:1,9'],
            'image_path' => ['required','image','max:5120'],
            'document_path' => ['required','file','mimes:pdf','max:10240'],
            'video_url' => ['nullable','url'],
            'contact' => ['required','string','max:255'],
            'status' => ['nullable', Rule::in($validStatuses)],
        ]);

        $data = $request->only([
            'title','category','subcategory','author_name','institution',
            'keywords','description','purpose','technology_readiness_level',
            'video_url','contact','status'
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = $request->input('status') ?: AcademicInnovation::STATUS_DRAFT;

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('gambar_inovasi','public');
        }
        if ($request->hasFile('document_path')) {
            $data['document_path'] = $request->file('document_path')->store('dokumen_inovasi','public');
        }

        AcademicInnovation::create($data);

        return redirect()->route('akademisi.inovasi.index')
            ->with('success','Inovasi berhasil disimpan.');
    }

    // =========================================================
    // SHOW: detail inovasi
    // =========================================================
    public function show($id)
    {
        $innovation = AcademicInnovation::findOrFail($id);

        $yearlyInnovations = AcademicInnovation::where('user_id', Auth::id())
            ->where('id','!=',$id)
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn($item)=>$item->created_at->format('Y'));

        $latest = AcademicInnovation::where('status', AcademicInnovation::STATUS_PUBLICATION)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('akademisi.inovasi-detail', compact('innovation','yearlyInnovations','latest'));
    }

    // =========================================================
    // EDIT: form ubah inovasi
    // =========================================================
    public function edit($id)
    {
        $innovation = AcademicInnovation::findOrFail($id);
        if(Auth::id() != $innovation->user_id) abort(403);

        $categories = Subcategory::select('category')->distinct()->pluck('category');
        $yearlyInnovations = AcademicInnovation::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(fn($item)=>$item->created_at->format('Y'));

        $latest = AcademicInnovation::where('status', AcademicInnovation::STATUS_PUBLICATION)
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('akademisi.inovasi-edit', compact('innovation','categories','yearlyInnovations','latest'));
    }

    // =========================================================
    // UPDATE: simpan perubahan inovasi
    // =========================================================
    public function update(Request $request, $id)
    {
        $innovation = AcademicInnovation::findOrFail($id);
        if(Auth::id() != $innovation->user_id) abort(403);

        $validStatuses = AcademicInnovation::statuses();

        $request->validate([
            'title'=>['required','string','max:255'],
            'category'=>['required','string'],
            'subcategory'=>['required','string'],
            'author_name'=>['required','string','max:255'],
            'institution'=>['required','string','max:255'],
            'keywords'=>['required','string'],
            'description'=>['required','string'],
            'purpose'=>['required','string'],
            'technology_readiness_level'=>['required','integer','between:1,9'],
            'image_path'=>['nullable','image','max:5120'],
            'document_path'=>['nullable','file','mimes:pdf','max:10240'],
            'video_url'=>['nullable','url'],
            'contact'=>['required','string','max:255'],
            'status'=>['nullable',Rule::in($validStatuses)],
        ]);

        $data = $request->only([
            'title','category','subcategory','author_name','institution',
            'keywords','description','purpose','technology_readiness_level',
            'video_url','contact','status'
        ]);

        $data['status'] = $request->input('status') ?: AcademicInnovation::STATUS_DRAFT;

        if($request->hasFile('image_path')){
            if($innovation->image_path && Storage::disk('public')->exists($innovation->image_path)){
                Storage::disk('public')->delete($innovation->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('gambar_inovasi','public');
        }

        if($request->hasFile('document_path')){
            if($innovation->document_path && Storage::disk('public')->exists($innovation->document_path)){
                Storage::disk('public')->delete($innovation->document_path);
            }
            $data['document_path'] = $request->file('document_path')->store('dokumen_inovasi','public');
        }

        $innovation->update($data);

        return redirect()->route('akademisi.inovasi.show',$innovation->id)
            ->with('success','Inovasi berhasil diperbarui!');
    }

    // =========================================================
    // DESTROY: hapus inovasi
    // =========================================================
    public function destroy($id)
    {
        $innovation = AcademicInnovation::findOrFail($id);
        if(Auth::id() != $innovation->user_id) abort(403);

        if($innovation->image_path && Storage::disk('public')->exists($innovation->image_path)){
            Storage::disk('public')->delete($innovation->image_path);
        }
        if($innovation->document_path && Storage::disk('public')->exists($innovation->document_path)){
            Storage::disk('public')->delete($innovation->document_path);
        }

        $innovation->delete();

        return redirect()->route('akademisi.inovasi.index')
            ->with('success', 'Inovasi berhasil dihapus.');
    }

    // =========================================================
    // AJAX: ambil subkategori berdasarkan kategori
    // =========================================================
    public function subcategories(Request $request)
    {
        $category = $request->query('category');

        if(!$category) return response()->json([]);

        $subs = Subcategory::where('category',$category)
            ->orderBy('name')
            ->pluck('name');

        return response()->json($subs);
    }
}
