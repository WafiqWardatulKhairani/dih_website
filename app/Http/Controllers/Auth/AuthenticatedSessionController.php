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
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate(); // sudah cek rejected

    $request->session()->regenerate();

    // Kalau status pending → arahkan ke landing-page
    if (Auth::user()->status === 'pending') {
        return redirect()->route('landing-page');
    }

    return match (Auth::user()->role) {
        'pemerintah' => redirect()->route('pemerintah.index'),
        'akademisi'  => redirect()->route('akademisi.index'),
        'admin'      => redirect()->route('admin.index'),
        default      => redirect()->route('landing-page'),
    };
}


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing-page');
    }
}
