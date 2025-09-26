<?php

namespace App\Http\Controllers\Akademisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Innovation;
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

    // form create
    public function create()
    {
        $categories = Subcategory::select('category')->distinct()->pluck('category');
        // ambil inovasi user untuk sidebar
        $innovations = Innovation::where('user_id', Auth::id())
                        ->orderByDesc('created_at')
                        ->get()
                        ->groupBy(function($item){
                            return $item->created_at->format('Y');
                        });

        return view('akademisi.inovasi', compact('categories', 'innovations'));
    }

    // store
    public function store(Request $request)
    {
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
            // validate status if provided
            'status' => ['nullable', Rule::in(Innovation::statuses())],
        ]);

        $data = $request->only([
            'title','category','subcategory','author_name','institution','keywords',
            'description','purpose','technology_readiness_level','video_url','contact','status'
        ]);

        // assign user and default status (if not provided)
        $data['user_id'] = Auth::id();
        $data['status'] = $request->input('status', Innovation::STATUS_DRAFT);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('gambar_inovasi','public');
        }

        if ($request->hasFile('document_path')) {
            $data['document_path'] = $request->file('document_path')->store('dokumen_inovasi','public');
        }

        $innovation = Innovation::create($data);

        return redirect()->route('akademisi.inovasi.create')->with('success','Inovasi berhasil disimpan (status: '.$innovation->status.').');
    }

    // list / index
    public function index()
    {
        $innovations = Innovation::where('user_id', Auth::id())
                        ->orderByDesc('created_at')
                        ->get()
                        ->groupBy(function($item){
                            return $item->created_at->format('Y');
                        });

        return view('akademisi.index', compact('innovations'));
    }

    // detail
    public function show($id)
    {
        $innovation = Innovation::findOrFail($id);
        return view('akademisi.inovasi-detail', compact('innovation'));
    }

    // form edit
    public function edit($id)
    {
        $innovation = Innovation::findOrFail($id);
        
        // Authorization check - hanya pemilik yang bisa edit
        if (Auth::id() != $innovation->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $categories = Subcategory::select('category')->distinct()->pluck('category');
        
        // ambil inovasi user untuk sidebar
        $innovations = Innovation::where('user_id', Auth::id())
                        ->orderByDesc('created_at')
                        ->get()
                        ->groupBy(function($item){
                            return $item->created_at->format('Y');
                        });

        return view('akademisi.inovasi-edit', compact('innovation', 'categories', 'innovations'));
    }

    // update
    public function update(Request $request, $id)
    {
        $innovation = Innovation::findOrFail($id);
        
        // Authorization check
        if (Auth::id() != $innovation->user_id) {
            abort(403, 'Unauthorized action.');
        }

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
            'image_path' => ['nullable','image','max:5120'],
            'document_path' => ['nullable','file','mimes:pdf','max:10240'],
            'video_url' => ['nullable','url'],
            'contact' => ['required','string','max:255'],
            'status' => ['nullable', Rule::in(Innovation::statuses())],
        ]);

        $data = $request->only([
            'title','category','subcategory','author_name','institution','keywords',
            'description','purpose','technology_readiness_level','video_url','contact','status'
        ]);

        // Handle image upload
        if ($request->hasFile('image_path')) {
            // Hapus gambar lama jika ada
            if ($innovation->image_path) {
                Storage::disk('public')->delete($innovation->image_path);
            }
            $data['image_path'] = $request->file('image_path')->store('gambar_inovasi','public');
        }

        // Handle document upload
        if ($request->hasFile('document_path')) {
            // Hapus dokumen lama jika ada
            if ($innovation->document_path) {
                Storage::disk('public')->delete($innovation->document_path);
            }
            $data['document_path'] = $request->file('document_path')->store('dokumen_inovasi','public');
        }

        // Update status jika tidak diisi
        if (!$request->has('status')) {
            $data['status'] = $innovation->status; // Pertahankan status lama
        }

        $innovation->update($data);

        // PERBAIKAN: Gunakan route yang benar - sesuaikan dengan routes Anda
        return redirect()->route('akademisi.inovasi.show', $innovation->id)
            ->with('success', 'Inovasi berhasil diperbarui!');
    }

    // ajax get subcategories by category
    public function subcategories(Request $request)
    {
        $category = $request->query('category');
        if (!$category) {
            return response()->json([]);
        }
        $subs = Subcategory::where('category', $category)->orderBy('name')->pluck('name');
        return response()->json($subs);
    }
}