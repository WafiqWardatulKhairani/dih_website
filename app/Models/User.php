<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\ValueObjects\EmailAddress;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang bisa diisi massal
     */
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

    /**
     * Atribut yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast atribut ke tipe data tertentu
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'approved_at' => 'datetime',
    ];

    /**
     * Mengembalikan objek Value Object EmailAddress
     */
    public function emailVO(): EmailAddress
    {
        return new EmailAddress($this->email);
    }

    /**
     * Cek apakah email merupakan email institusi.
     * Delegasi ke VO EmailAddress
     */
    public function isInstitutionalEmail(): bool
    {
        return $this->emailVO()->isInstitutional();
    }

    /**
     * Method untuk auto approve user
     */
    public function approve(): void
    {
        $this->update([
            'status' => 'verified',
            'approved_at' => now(),
        ]);
    }
}
