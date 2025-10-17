<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KolaborasiProject extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_projects';
    
    protected $fillable = [
        'kolaborasi_idea_id', 
        'nama_proyek', 
        'deskripsi', 
        'tanggal_mulai',
        'tanggal_selesai', 
        'status', 
        'progress'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Constants for status
    const STATUS_PLANNING = 'planning';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_ON_HOLD = 'on_hold';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Relationship dengan ide
     */
    public function idea(): BelongsTo
    {
        return $this->belongsTo(KolaborasiIdea::class, 'kolaborasi_idea_id');
    }

    /**
     * Relationship dengan anggota
     */
    public function anggota(): HasMany
    {
        return $this->hasMany(KolaborasiAnggota::class, 'kolaborasi_project_id');
    }

    /**
     * Relationship dengan tugas
     */
    public function tugas(): HasMany
    {
        return $this->hasMany(KolaborasiTugas::class, 'kolaborasi_project_id');
    }

    /**
     * Relationship dengan dokumentasi
     */
    public function dokumentasi(): HasMany
    {
        return $this->hasMany(KolaborasiDokumentasi::class, 'kolaborasi_project_id');
    }

    /**
     * Relationship dengan aktivitas
     */
    public function aktivitas(): HasMany
    {
        return $this->hasMany(KolaborasiAktivitas::class, 'kolaborasi_project_id');
    }

    /**
     * Relationship dengan reviews
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(KolaborasiReview::class, 'kolaborasi_project_id');
    }

    /**
     * Methods for progress tracking
     */
    public function updateProgress(): void
    {
        $totalTasks = $this->tugas()->count();
        if ($totalTasks > 0) {
            $completedTasks = $this->tugas()->where('status', 'completed')->count();
            $this->progress = round(($completedTasks / $totalTasks) * 100);
            $this->save();
        }
    }

    /**
     * Get leader of the project
     */
    public function getLeaderAttribute()
    {
        return $this->anggota()->where('role', KolaborasiAnggota::ROLE_LEADER)->first();
    }

    /**
     * Get all members (excluding leader)
     */
    public function getMembersAttribute()
    {
        return $this->anggota()->where('role', KolaborasiAnggota::ROLE_MEMBER)->get();
    }

    /**
     * Get all reviewers
     */
    public function getReviewersAttribute()
    {
        return $this->anggota()->where('role', KolaborasiAnggota::ROLE_REVIEWER)->get();
    }

    /**
     * Check if user is member of this project
     */
    public function isMember($userId): bool
    {
        return $this->anggota()->where('user_id', $userId)->exists();
    }

    /**
     * Check if user is leader of this project
     */
    public function isLeader($userId): bool
    {
        return $this->anggota()
            ->where('user_id', $userId)
            ->where('role', KolaborasiAnggota::ROLE_LEADER)
            ->exists();
    }
}