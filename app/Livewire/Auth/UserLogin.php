<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserLogin extends Component
{
    public $email, $password, $remember = false;

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Coba login
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            
            $user = Auth::user();
            
            // Cek status user
            if ($user->status === 'rejected') {
                Auth::logout();
                $this->addError('email', 'Akun Anda telah ditolak.');
                return;
            }

            if ($user->status !== 'verified') {
                Auth::logout();
                $this->addError('email', 'Akun belum diverifikasi admin.');
                return;
            }

            session()->regenerate();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.index');
            } elseif ($user->role === 'pemerintah') {
                return redirect()->route('pemerintah.index');
            } elseif ($user->role === 'akademisi') {
                return redirect()->route('akademisi.index');
            }

            return redirect()->route('landing-page');
        }

        $this->addError('email', 'Email atau password salah.');
    }

    public function render()
    {
        return view('livewire.auth.user-login');
    }
}