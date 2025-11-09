<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\OpdProgram;
use App\Models\OpdInnovation;
use App\Models\AcademicInnovation;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profil user
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $programs = collect();
        $innovations = collect();
        $stats = [];

        if ($user->role === 'pemerintah') {
            // Ambil program & inovasi pemerintah
            $programs = OpdProgram::where('user_id', $user->id)
                ->latest()
                ->paginate(12, ['*'], 'program_page')
                ->withQueryString();

            $innovations = OpdInnovation::where('user_id', $user->id)
                ->latest()
                ->paginate(12, ['*'], 'innovation_page')
                ->withQueryString();

            // Fallback jika tidak ada data berdasarkan user_id
            if ($programs->isEmpty()) {
                $programs = OpdProgram::where('opd_name', 'LIKE', '%' . $user->institution_name . '%')
                    ->latest()
                    ->paginate(12, ['*'], 'program_page')
                    ->withQueryString();
            }

            if ($innovations->isEmpty()) {
                $innovations = OpdInnovation::where('author_name', $user->name)
                    ->latest()
                    ->paginate(12, ['*'], 'innovation_page')
                    ->withQueryString();
            }

            // Statistik lengkap (semua data, bukan hanya halaman sekarang)
            $allPrograms = OpdProgram::where('user_id', $user->id)->get();
            $allInnovations = OpdInnovation::where('user_id', $user->id)->get();

            if ($allPrograms->isEmpty()) {
                $allPrograms = OpdProgram::where('opd_name', 'LIKE', '%' . $user->institution_name . '%')->get();
            }

            if ($allInnovations->isEmpty()) {
                $allInnovations = OpdInnovation::where('author_name', $user->name)->get();
            }

            $stats = $this->calculateStats($allPrograms, $allInnovations);
        } elseif ($user->role === 'akademisi') {
            // Ambil inovasi akademisi
            $innovations = AcademicInnovation::where('user_id', $user->id)
                ->latest()
                ->paginate(12, ['*'], 'innovation_page')
                ->withQueryString();

            if ($innovations->isEmpty()) {
                $innovations = AcademicInnovation::where('author_name', $user->name)
                    ->latest()
                    ->paginate(12, ['*'], 'innovation_page')
                    ->withQueryString();
            }

            $allInnovations = AcademicInnovation::where('user_id', $user->id)->get();
            if ($allInnovations->isEmpty()) {
                $allInnovations = AcademicInnovation::where('author_name', $user->name)->get();
            }

            $stats = $this->calculateAcademicStats($allInnovations);
        }

        return view('profile.edit', compact('user', 'programs', 'innovations', 'stats'));
    }

    /**
     * Hitung statistik pemerintah
     */
    private function calculateStats($programs, $innovations): array
    {
        $oneYearAgo = Carbon::now()->subYear();

        return [
            'total_programs' => $programs->count(),
            'total_innovations' => $innovations->count(),
            'programs_last_year' => $programs->where('created_at', '>=', $oneYearAgo)->count(),
            'innovations_last_year' => $innovations->where('created_at', '>=', $oneYearAgo)->count(),
            'programs_by_status' => $programs->groupBy('status')->map->count(),
            'innovations_by_status' => $innovations->groupBy('status')->map->count(),
            'total_budget' => $programs->sum('budget'),
            'avg_progress' => $programs->avg('progress') ?? 0,
        ];
    }

    /**
     * Hitung statistik akademisi
     */
    private function calculateAcademicStats($innovations): array
    {
        $oneYearAgo = Carbon::now()->subYear();

        $categoryCounts = $innovations->groupBy('category')->map->count();
        $mostFrequentCategory = $categoryCounts->isNotEmpty() ? $categoryCounts->sortDesc()->keys()->first() : null;

        return [
            'total_innovations' => $innovations->count(),
            'innovations_last_year' => $innovations->where('created_at', '>=', $oneYearAgo)->count(),
            'innovations_by_status' => $innovations->groupBy('status')->map->count(),
            'innovations_by_category' => $categoryCounts,
            'most_frequent_category' => $mostFrequentCategory,
        ];
    }

    /**
     * Update profil user
     */
    /**
 * Update profil user
 */
public function update(Request $request): RedirectResponse
{
    $user = $request->user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'institution_name' => 'required|string|max:255',
        'address' => 'nullable|string',
        'phone' => 'nullable|string|max:20',
        'document_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
    ]);

    // Update user data
    $user->name = $validated['name'];
    $user->institution_name = $validated['institution_name'];
    $user->address = $validated['address'] ?? '';
    $user->phone = $validated['phone'] ?? '';

    // Handle document upload
    if ($request->hasFile('document_path')) {
        // Delete old document if exists
        if ($user->document_path && Storage::exists('public/' . $user->document_path)) {
            Storage::delete('public/' . $user->document_path);
        }
        
        // Store new document
        $documentPath = $request->file('document_path')->store('documents', 'public');
        $user->document_path = $documentPath;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated')
                                           ->with('success', 'Profil berhasil diperbarui!');
}

    /**
     * Hapus akun user
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
