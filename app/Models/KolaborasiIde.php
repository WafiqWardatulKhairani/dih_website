<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KolaborasiIde extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_ideas';

    protected $fillable = [
        'judul',
        'deskripsi_singkat',
        'user_id',             
        'field',
        'estimasi_waktu',
        'is_active',
        'category',
        'subcategory',
        'innovation_id',
        'innovation_type', 
        'dokumen_path',
        'image_path',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    /* ============================================================
     |  RELATIONSHIPS
     |============================================================ */

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id')
            ->withDefault(['name' => 'Tidak Diketahui']);
    }

    public function members()
    {
        return $this->hasMany(KolaborasiMember::class, 'kolaborasi_id');
    }

    public function tasks()
    {
        return $this->hasMany(KolaborasiTask::class, 'kolaborasi_id');
    }

    public function progress()
    {
        return $this->hasMany(KolaborasiProgress::class, 'kolaborasi_id');
    }

    public function documents()
    {
        return $this->hasMany(KolaborasiDocument::class, 'kolaborasi_id');
    }

    public function reviews()
    {
        return $this->hasMany(KolaborasiReview::class, 'kolaborasi_id');
    }

    public function academicInnovation()
    {
        return $this->belongsTo(AcademicInnovation::class, 'innovation_id');
    }

    public function opdInnovation()
    {
        return $this->belongsTo(OpdInnovation::class, 'innovation_id');
    }

    public function innovation()
    {
        return $this->innovation_type === 'academic'
            ? $this->academicInnovation
            : ($this->innovation_type === 'opd'
                ? $this->opdInnovation
                : null);
    }

    /* ============================================================
     |  ACCESSORS
     |============================================================ */

    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'Aktif' : 'Belum Aktif';
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->is_active
            ? '<span class="badge bg-success">Aktif</span>'
            : '<span class="badge bg-secondary">Belum Aktif</span>';
    }

    public function getDocumentUrlAttribute(): ?string
    {
        return $this->dokumen_path ? Storage::url($this->dokumen_path) : null;
    }

    public function getImageUrlAttribute(): ?string
    {
        return ($this->image_path && Storage::exists($this->image_path))
            ? Storage::url($this->image_path)
            : asset('images/defaults/kolaborasi-cover.png');
    }

    public function getTitleAttribute(): string
    {
        return $this->attributes['judul'] ?? '';
    }

    public function getDescriptionAttribute(): string
    {
        return $this->attributes['deskripsi_singkat'] ?? '';
    }

    public function getEstimatedDurationAttribute(): ?string
    {
        return $this->attributes['estimasi_waktu'] ?? null;
    }

    /* ============================================================
     |  MUTATORS
     |============================================================ */

    public function setTitleAttribute($value): void
    {
        $this->attributes['judul'] = ucfirst(trim($value));
    }

    public function setDescriptionAttribute($value): void
    {
        $this->attributes['deskripsi_singkat'] = ucfirst(trim($value));
    }

    public function setEstimatedDurationAttribute($value): void
    {
        $this->attributes['estimasi_waktu'] = $value;
    }

    /* ============================================================
     |  SCOPES
     |============================================================ */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLatestFirst($query)
    {
        return $query->latest('created_at');
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
              ->orWhere('deskripsi_singkat', 'like', "%{$keyword}%");
        });
    }

    /* ============================================================
     |  AGGREGATE METHODS / BUSINESS RULES
     |============================================================ */

    /** Hitung jumlah anggota aktif termasuk owner jika belum leader */
    public function activeMembersCount(): int
    {
        $count = $this->members()->where('status', 'active')->count();

        $ownerId = $this->innovation_type === 'academic'
            ? $this->academicInnovation?->user_id
            : $this->opdInnovation?->user_id;

        $leaderId = $this->members()->where('role', 'leader')->value('user_id');

        if ($ownerId && $ownerId != $leaderId) $count += 1;

        return $count;
    }

    /** Hitung progress (%) kolaborasi */
    public function progressPercent(): float
    {
        $total = $this->tasks()->count();
        $done  = $this->tasks()->where('status', 'done')->count();

        return $total > 0 ? ($done / $total) * 100 : 0;
    }

    /** Cek apakah user pemilik inovasi */
    public function isOwnedByUser($userId): bool
    {
        $model = $this->innovation();

        return $model && $model->user_id === $userId;
    }

    /** Cek apakah user adalah leader kolaborasi */
    public function isLeader($userId): bool
    {
        return $this->user_id === $userId;
    }

    /** Cek apakah user adalah member aktif */
    public function isMember($userId): bool
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    /** Cek apakah user boleh join kolaborasi */
    public function canJoin($userId): bool
    {
        return !$this->isLeader($userId) &&
               !$this->isMember($userId) &&
               !$this->isOwnedByUser($userId);
    }
}
