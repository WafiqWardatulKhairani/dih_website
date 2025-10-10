<?php

namespace App\Http\Controllers\Pemerintah;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\ProgramPemerintah;
use App\Models\OpdProgram;
use App\Models\OpdInnovation;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = ProgramPemerintah::latest()->take(6)->get();
        return view('landing.landing_page', compact('programs'));
    }
    
    // ✅ METHOD BARU UNTUK HALAMAN RINGKASAN PROGRAM & INOVASI
    public function programPage()
    {
        // Get 10 programs and innovations for preview (compact cards)
        $programs = OpdProgram::latest()->take(10)->get();
        $innovations = OpdInnovation::latest()->take(10)->get();
        
        // Statistics for the dashboard
        $totalPrograms = OpdProgram::count();
        $totalInnovations = OpdInnovation::count();
        $programsOngoing = OpdProgram::where('status', 'ongoing')->count();
        $innovationsReady = OpdInnovation::where('status', 'ready')->count();

        return view('pemerintah.program', compact(
            'programs',
            'innovations',
            'totalPrograms',
            'totalInnovations',
            'programsOngoing',
            'innovationsReady'
        ));
    }

    // ✅ FUNGSI UNTUK PROGRAM & INOVASI (tab version - bisa dihapus kalau tidak dipakai)
    public function programInnovationIndex()
    {
        $programs = OpdProgram::latest()->paginate(15);
        $innovations = OpdInnovation::latest()->paginate(15);
        
        return view('pemerintah.program', compact('programs', 'innovations'));
    }

    // ✅ HALAMAN SEMUA PROGRAM (dengan pagination)
    public function showPrograms()
    {
        $programs = OpdProgram::latest()->paginate(15);
        return view('pemerintah.program-list', compact('programs'));
    }

    // ✅ HALAMAN SEMUA INOVASI (dengan pagination)
    public function showInnovations()
    {
        $innovations = OpdInnovation::latest()->paginate(15);
        return view('pemerintah.inovasi', compact('innovations'));
    }

    // ✅ FUNGSI CREATE/POSTING PROGRAM
    public function createProgram()
    {
        return view('pemerintah.create-program');
    }

    public function storeProgram(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'opd_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|in:planning,ongoing,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'progress' => 'required|integer|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('program-images', 'public');
            $validated['image'] = $imagePath;
        }

        OpdProgram::create($validated);

        return redirect()->route('pemerintah.program')->with('success', 'Program berhasil diposting!');
    }

    // ✅ FUNGSI CREATE/POSTING INOVASI
    public function createInnovation()
    {
        // Ambil data inovasi untuk sidebar (hanya milik OPD yang login)
        $innovations = OpdInnovation::latest()->get();
        
        return view('pemerintah.create-innovation', compact('innovations'));
    }

    public function storeInnovation(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'institution' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'subcategory' => 'nullable|string|max:255',
        'author_name' => 'required|string|max:255',
        'keywords' => 'nullable|string',
        'purpose' => 'nullable|string',
        'technology_readiness_level' => 'required|integer|min:1|max:9',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'document_path' => 'nullable|file|mimes:pdf|max:10240',
        'video_url' => 'nullable|url',
        'contact' => 'nullable|string|max:255',
        'status' => 'required|in:draft,review,publication'
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('innovation-images', 'public');
        $validated['image'] = $imagePath;
    }

    // Handle document upload
    if ($request->hasFile('document_path')) {
        $documentPath = $request->file('document_path')->store('innovation-documents', 'public');
        $validated['document_path'] = $documentPath;
    }

    // Set default author name jika kosong
    $validated['author_name'] = $validated['author_name'] ?? auth()->user()->name;

    OpdInnovation::create($validated);

    // ✅ PERBAIKI INI - redirect ke halaman program ringkasan
    return redirect()->route('pemerintah.program')->with('success', 'Inovasi berhasil diposting!');
}

    // ✅ FUNGSI EDIT/UPDATE PROGRAM
    public function editProgram($id)
    {
        $program = OpdProgram::findOrFail($id);
        return view('pemerintah.edit-program', compact('program'));
    }

    public function updateProgram(Request $request, $id)
    {
        $program = OpdProgram::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'opd_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|in:planning,ongoing,completed',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'progress' => 'required|integer|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($program->image) {
                Storage::disk('public')->delete($program->image);
            }
            $imagePath = $request->file('image')->store('program-images', 'public');
            $validated['image'] = $imagePath;
        }

        $program->update($validated);

        return redirect()->route('program.list')->with('success', 'Program berhasil diupdate!');
    }
// ✅ HALAMAN DETAIL PROGRAM
public function showProgramDetail($id)
{
    $program = OpdProgram::findOrFail($id);
    return view('pemerintah.program-detail', compact('program'));
}

// ✅ HALAMAN DETAIL INOVASI  
public function showInnovationDetail($id)
{
    $innovation = OpdInnovation::findOrFail($id);
    return view('pemerintah.innovation-detail', compact('innovation'));
}
    // ✅ FUNGSI EDIT/UPDATE INOVASI
    public function editInnovation($id)
    {
        $innovation = OpdInnovation::findOrFail($id);
        return view('pemerintah.edit-innovation', compact('innovation'));
    }

    public function updateInnovation(Request $request, $id)
    {
        $innovation = OpdInnovation::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'institution' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|in:research,prototype,ready,implemented',
            'innovation_type' => 'required|in:technology,service,process,product',
            'research_duration' => 'required|integer|min:1',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_verified' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['is_verified'] = $request->has('is_verified');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($innovation->image) {
                Storage::disk('public')->delete($innovation->image);
            }
            $imagePath = $request->file('image')->store('innovation-images', 'public');
            $validated['image'] = $imagePath;
        }

        $innovation->update($validated);

        return redirect()->route('program.innovation.list')->with('success', 'Inovasi berhasil diupdate!');
    }

    // ✅ FUNGSI DELETE PROGRAM
    public function destroyProgram($id)
    {
        $program = OpdProgram::findOrFail($id);
        
        // Delete image if exists
        if ($program->image) {
            Storage::disk('public')->delete($program->image);
        }
        
        $program->delete();

        return redirect()->route('program.list')->with('success', 'Program berhasil dihapus!');
    }

    // ✅ FUNGSI DELETE INOVASI
    public function destroyInnovation($id)
    {
        $innovation = OpdInnovation::findOrFail($id);
        
        // Delete image if exists
        if ($innovation->image) {
            Storage::disk('public')->delete($innovation->image);
        }
        
        $innovation->delete();

        return redirect()->route('program.innovation.list')->with('success', 'Inovasi berhasil dihapus!');
    }
}