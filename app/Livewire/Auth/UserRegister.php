<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class UserRegister extends Component
{
    use WithFileUploads;

    public $name, $institution_name, $phone, $address,
        $email, $password, $password_confirmation,
        $role, $document, $avatar;

    protected function rules()
    {
        return [
            'name'              => 'required|string|max:255',
            'institution_name'  => 'required|string|max:255',
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => ['required', 'confirmed', Rules\Password::defaults()],
            'role'              => 'required|in:pemerintah,akademisi',
            'document'          => 'required|file|mimes:pdf|max:2048',
            'avatar'            => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function register()
    {
        // Validasi input & file
        $validated = $this->validate($this->rules());

        try {
            $docFolder = $validated['role']; // "akademisi" atau "pemerintah"

            // Sanitasi nama untuk nama file
            $safeName = Str::slug($validated['name'], '_');

            // Simpan avatar
            $avatarExt = $this->avatar->getClientOriginalExtension();
            $avatarName = $safeName . '_avatar.' . $avatarExt;
            $avatarPath = $this->avatar->storeAs("avatars/{$docFolder}", $avatarName, 'public');

            // Simpan dokumen
            $docExt = $this->document->getClientOriginalExtension();
            $documentName = $safeName . '_document.' . $docExt;
            $documentPath = $this->document->storeAs("documents/{$docFolder}", $documentName, 'public');

            // Simpan user ke database
            User::create([
                'name'             => $validated['name'],
                'institution_name' => $validated['institution_name'],
                'phone'            => $validated['phone'],
                'address'          => $validated['address'],
                'email'            => $validated['email'],
                'password'         => Hash::make($validated['password']),
                'role'             => $validated['role'],
                'document_path'    => $documentPath,
                'avatar'           => $avatarPath,
                'status'           => 'pending',
            ]);

            session()->flash('registration_pending', true);
            session()->flash('success', 'Registrasi berhasil! Akun Anda menunggu verifikasi admin.');

            $this->dispatch(
                'swal:success',
                title: 'Registrasi Berhasil!',
                message: 'Akun Anda sedang menunggu verifikasi admin.',
                redirect: route('landing-page'),
                timer: 5000
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'swal:error',
                title: 'Registrasi Gagal!',
                message: 'Terjadi kesalahan: ' . $e->getMessage()
            );
        }
    }

    public function render()
    {
        return view('livewire.auth.user-register')
            ->extends('layouts.app')
            ->section('content');
    }
}