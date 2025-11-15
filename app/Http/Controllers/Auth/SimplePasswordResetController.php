<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SimplePasswordResetController extends Controller
{
    /**
     * Display the simple password reset view.
     */
    public function create(): View
    {
        return view('landing.auth.simple-forgot-password');
    }

    /**
     * Handle the simple password reset.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email yang Anda masukkan salah.'
            ])->withInput();
        }

        // Update password user
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // REDIRECT LANGSUNG KE LANDING PAGE
        return redirect('/')
            ->with('password_reset_success', 'Kata sandi berhasil diubah! Silakan login dengan password baru Anda.');
    }
}