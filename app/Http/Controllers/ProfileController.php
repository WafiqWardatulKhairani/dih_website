<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\OpdProgram;
use App\Models\OpdInnovation;
use App\Models\AcademicInnovation;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();

        $programs = collect();
        $innovations = collect();
        $stats = [];

        if ($user->role === 'pemerintah') {
            // Untuk pemerintah, ambil dari opd_programs dan opd_innovations dengan pagination 12 item
            $programs = OpdProgram::where('user_id', $user->id)
                ->latest()
                ->paginate(12, ['*'], 'program_page')
                ->withQueryString();

            $innovations = OpdInnovation::where('user_id', $user->id)
                ->latest()
                ->paginate(12, ['*'], 'innovation_page')
                ->withQueryString();

            // FALLBACK: Jika tidak ada program dengan user_id, coba dengan opd_name yang sesuai
            if ($programs->isEmpty()) {
                $programs = OpdProgram::where('opd_name', 'LIKE', '%' . $user->institution_name . '%')
                    ->latest()
                    ->paginate(12, ['*'], 'program_page')
                    ->withQueryString();
            }

            // FALLBACK: Jika tidak ada inovasi dengan user_id, coba dengan author_name
            if ($innovations->isEmpty()) {
                $innovations = OpdInnovation::where('author_name', $user->name)
                    ->latest()
                    ->paginate(12, ['*'], 'innovation_page')
                    ->withQueryString();
            }

            // Hitung statistik (gunakan semua data, bukan hanya yang ditampilkan)
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
            // Untuk akademisi, ambil dari academic_innovations dengan pagination 12 item
            $innovations = AcademicInnovation::where('user_id', $user->id)
                ->latest()
                ->paginate(12, ['*'], 'innovation_page')
                ->withQueryString();

            // Fallback untuk akademisi
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
     * Hitung statistik untuk pemerintah
     */
    private function calculateStats($programs, $innovations)
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
     * Hitung statistik untuk akademisi
     */
    private function calculateAcademicStats($innovations)
    {
        $oneYearAgo = Carbon::now()->subYear();

        // Hitung kategori terbanyak
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
     * Update data profil user.
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

        // Update data user
        $user->name = $validated['name'];
        $user->institution_name = $validated['institution_name'];
        $user->address = $validated['address'];
        $user->phone = $validated['phone'];

        // Handle upload dokumen
        if ($request->hasFile('document_path')) {
            if ($user->document_path) {
                Storage::delete('public/' . $user->document_path);
            }

            $path = $request->file('document_path')->store('documents', 'public');
            $user->document_path = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun user.
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
