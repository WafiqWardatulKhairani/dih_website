<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;

class UserRegister extends Component
{
    use WithFileUploads;

    public $name, $institution_name, $phone, $address,
        $email, $password, $password_confirmation,
        $role, $document, $avatar;

    public $approvalType = 'manual';
    public $showCountdown = false;
    public $countdown = 180;

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

    // ✅ PERBAIKAN: Ganti jadi updated hook
    public function updated($property)
    {
        if ($property === 'email') {
            $this->checkEmailType();
        }
    }

    // ✅ Method terpisah untuk cek email type
    public function checkEmailType()
    {
        if (!empty($this->email)) {
            $user = new User(['email' => $this->email]);
            $this->approvalType = $user->isInstitutionalEmail() ? 'auto' : 'manual';
        }
    }

    public function register()
    {
        $validated = $this->validate($this->rules());

        try {
            $docFolder = $validated['role'];
            $safeName = Str::slug($validated['name'], '_');

            // Simpan avatar
            $avatarExt = $this->avatar->getClientOriginalExtension();
            $avatarName = $safeName . '_avatar.' . $avatarExt;
            $avatarPath = $this->avatar->storeAs("avatars/{$docFolder}", $avatarName, 'public');

            // Simpan dokumen
            $docExt = $this->document->getClientOriginalExtension();
            $documentName = $safeName . '_document.' . $docExt;
            $documentPath = $this->document->storeAs("documents/{$docFolder}", $documentName, 'public');

            // Buat user
            $user = User::create([
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
                'approval_type'    => $this->approvalType,
            ]);

            // Auto approve untuk email institutional
            if ($this->approvalType === 'auto') {
                // Schedule auto approval setelah 3 menit
                dispatch(function () use ($user) {
                    $user->update([
                        'status' => 'verified',
                        'approved_at' => now()
                    ]);
                })->delay(now()->addMinutes(3));

                $message = "Registrasi berhasil! Email institusi terdeteksi. Akun akan otomatis aktif dalam 3 menit.";
                $title = "Registrasi Berhasil - Auto Approval";
            } else {
                $message = "Registrasi berhasil! Akun Anda menunggu verifikasi admin.";
                $title = "Registrasi Berhasil - Menunggu Verifikasi";
            }

            $this->dispatch(
                'swal:success',
                title: $title,
                message: $message,
                redirect: route('landing-page'),
                timer: 5000
            );

        } catch (\Exception $e) {
            if (isset($avatarPath)) Storage::disk('public')->delete($avatarPath);
            if (isset($documentPath)) Storage::disk('public')->delete($documentPath);

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