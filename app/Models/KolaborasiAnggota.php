<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KolaborasiAnggota extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_anggota';
    
    protected $fillable = [
        'kolaborasi_project_id', 
        'user_id', 
        'role'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Constants for roles
    const ROLE_LEADER = 'leader';
    const ROLE_MEMBER = 'member';
    const ROLE_REVIEWER = 'reviewer';

    /**
     * Relationship dengan project
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(KolaborasiProject::class, 'kolaborasi_project_id');
    }

    /**
     * Relationship dengan user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk role leader
     */
    public function scopeLeaders($query)
    {
        return $query->where('role', self::ROLE_LEADER);
    }

    /**
     * Scope untuk role member
     */
    public function scopeMembers($query)
    {
        return $query->where('role', self::ROLE_MEMBER);
    }

    /**
     * Scope untuk role reviewer
     */
    public function scopeReviewers($query)
    {
        return $query->where('role', self::ROLE_REVIEWER);
    }

    /**
     * Accessor untuk label role
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            self::ROLE_LEADER => 'Leader',
            self::ROLE_MEMBER => 'Member',
            self::ROLE_REVIEWER => 'Reviewer',
            default => 'Unknown'
        };
    }

    /**
     * Check jika anggota adalah leader
     */
    public function getIsLeaderAttribute(): bool
    {
        return $this->role === self::ROLE_LEADER;
    }

    /**
     * Check jika anggota adalah reviewer
     */
    public function getIsReviewerAttribute(): bool
    {
        return $this->role === self::ROLE_REVIEWER;
    }
}