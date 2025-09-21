<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // ---- validasi status tetap sama ----
        if ($user->status === 'pending') {
            Auth::logout();
            return back()->with('error', 'Akun Anda sedang menunggu verifikasi admin. Silahkan tunggu hingga akun Anda diverifikasi.');
        }
        if ($user->status === 'rejected') {
            Auth::logout();
            return back()->with('error', 'Akun Anda ditolak. Silahkan hubungi administrator untuk informasi lebih lanjut.');
        }
        if ($user->status !== 'verified') {
            Auth::logout();
            return back()->with('error', 'Status akun tidak valid. Silahkan hubungi administrator.');
        }

        $request->session()->regenerate();

        // 🚀 redirect LANGSUNG sesuai role
        return match ($user->role) {
            'pemerintah' => redirect()->route('pemerintah.index'),
            'akademisi'  => redirect()->route('akademisi.index'),
            'admin'      => redirect()->route('admin.index'),
            default      => redirect()->route('landing-page'),
        };
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing-page');
    }

    protected function authenticated(Request $request, $user)
    {
        return match ($user->role) {
            'admin'      => route('admin.index'),
            'pemerintah' => route('pemerintah.index'),
            'akademisi'  => route('akademisi.index'),
            default      => route('landing-page'),
        };
    }
}
