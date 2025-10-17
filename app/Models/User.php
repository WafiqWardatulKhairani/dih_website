<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'institution_name',
        'phone',
        'address',
        'role',
        'document_path',
        'avatar',
        'status',
        'approved_at',
        'approval_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'approved_at' => 'datetime',
    ];

    // Method untuk cek email institusi
    public function isInstitutionalEmail()
    {
        $institutionalDomains = [
            'ac.id',           // Universitas
            'edu',             // Pendidikan internasional
            'sch.id',          // Sekolah
            'go.id',           // Pemerintah
            'yahoo.com',       // Pemerintah
        ];

        $emailDomain = strtolower(explode('@', $this->email)[1] ?? '');

        foreach ($institutionalDomains as $domain) {
            if (str_ends_with($emailDomain, $domain)) {
                return true;
            }
        }

        return false;
    }

    // Method untuk auto approve
    public function approve()
    {
        $this->update([
            'status' => 'verified',
            'approved_at' => now(),
        ]);
    }
}
