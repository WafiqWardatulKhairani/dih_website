<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KolaborasiMember extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_members';

    protected $fillable = [
        'kolaborasi_id',
        'user_id',
        'role',     // leader, member, observer
        'status',   // pending, active, rejected
    ];

    /*
    |--------------------------------------------------------------------------
    | 🔹 KONSTANTA
    |--------------------------------------------------------------------------
    */
    const ROLE_LEADER = 'leader';
    const ROLE_MEMBER = 'member';
    const ROLE_OBSERVER = 'observer';

    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_REJECTED = 'rejected';

    /*
    |--------------------------------------------------------------------------
    | 🔹 RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke ide kolaborasi induk.
     */
    public function kolaborasi()
    {
        return $this->belongsTo(KolaborasiIde::class, 'kolaborasi_id');
    }

    /**
     * Relasi ke user anggota kolaborasi.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => 'Tidak diketahui'
        ]);
    }

    /**
     * Relasi ke semua tugas yang ditugaskan ke user ini.
     */
    public function tasks()
    {
        return $this->hasMany(KolaborasiTask::class, 'assigned_to', 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔹 ACCESSORS & HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Label status untuk tampilan UI.
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_REJECTED => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    /**
     * Warna status (untuk badge UI).
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'green',
            self::STATUS_PENDING => 'yellow',
            self::STATUS_REJECTED => 'red',
            default => 'gray',
        };
    }

    /**
     * Label peran (role) anggota.
     */
    public function getRoleLabelAttribute()
    {
        return match ($this->role) {
            self::ROLE_LEADER => 'Ketua',
            self::ROLE_MEMBER => 'Anggota',
            self::ROLE_OBSERVER => 'Pengamat',
            default => ucfirst($this->role),
        };
    }

    /**
     * Warna role (untuk visualisasi).
     */
    public function getRoleColorAttribute()
    {
        return match ($this->role) {
            self::ROLE_LEADER => 'blue',
            self::ROLE_MEMBER => 'purple',
            self::ROLE_OBSERVER => 'gray',
            default => 'slate',
        };
    }

    /**
     * Cek apakah user ini adalah ketua kolaborasi.
     */
    public function getIsLeaderAttribute()
    {
        return $this->role === self::ROLE_LEADER;
    }

    /**
     * Cek apakah user ini anggota aktif.
     */
    public function getIsActiveAttribute()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /*
    |--------------------------------------------------------------------------
    | 🔹 SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Ambil hanya anggota yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Ambil hanya anggota yang pending.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Ambil hanya anggota yang ditolak.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    /**
     * Ambil hanya anggota dengan role tertentu.
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }
}
