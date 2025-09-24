<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserLogin extends Component
{
    public $email, $password, $remember = false;

    public function login()
    {
        // Validasi
        $credentials = $this->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Auth attempt
        if (Auth::attempt($credentials, $this->remember)) {

            // 🚫 Tambahkan blok ini di sini
            if (Auth::user()->status === 'rejected') {
                Auth::logout();
                $this->addError('email', 'Akun Anda telah ditolak dan tidak dapat login.');
                return;
            }

            // Tetap pakai pengecekan verified
            if (Auth::user()->status !== 'verified') {
                Auth::logout();
                $this->addError('email', 'Akun belum diverifikasi admin.');
                return;
            }

            session()->regenerate(); // keamanan

            // Redirect sesuai role
            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'pemerintah':
                    return redirect()->route('pemerintah.index');
                case 'akademisi':
                    return redirect()->route('akademisi.index');
                default:
                    Auth::logout();
                    $this->addError('email', 'Role tidak dikenali.');
                    return;
            }
        }

        // Gagal login
        $this->addError('email', 'Email atau password salah.');
    }


    public function render()
    {
        return view('livewire.auth.user-login')
            ->extends('layouts.app')
            ->section('content');
    }
}
