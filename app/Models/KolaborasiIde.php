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
        'user_id',             // Pengaju kolaborasi (leader)
        'field',
        'estimasi_waktu',
        'is_active',
        'category',
        'subcategory',
        'innovation_id',       // Relasi ke academic_innovations atau opd_innovations
        'innovation_type',     // 'academic' atau 'opd'
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

    /*
    |--------------------------------------------------------------------------
    | 🔹 RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Pemilik ide (pengaju kolaborasi utama / leader)
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => 'Tidak Diketahui',
        ]);
    }

    /**
     * Anggota kolaborasi
     */
    public function members()
    {
        return $this->hasMany(KolaborasiMember::class, 'kolaborasi_id');
    }

    /**
     * Tugas kolaborasi
     */
    public function tasks()
    {
        return $this->hasMany(KolaborasiTask::class, 'kolaborasi_id');
    }

    /**
     * Progress kolaborasi
     */
    public function progress()
    {
        return $this->hasMany(KolaborasiProgress::class, 'kolaborasi_id');
    }

    /**
     * Dokumen kolaborasi
     */
    public function documents()
    {
        return $this->hasMany(KolaborasiDocument::class, 'kolaborasi_id');
    }

    /**
     * Review kolaborasi
     */
    public function reviews()
    {
        return $this->hasMany(KolaborasiReview::class, 'kolaborasi_id');
    }

    /**
     * Relasi ke inovasi akademik (jika ide ini berasal dari akademik)
     */
    public function academicInnovation()
    {
        return $this->belongsTo(AcademicInnovation::class, 'innovation_id')
            ->where('innovation_type', 'academic');
    }

    /**
     * Relasi ke inovasi OPD (jika ide ini berasal dari OPD)
     */
    public function opdInnovation()
    {
        return $this->belongsTo(OpdInnovation::class, 'innovation_id')
            ->where('innovation_type', 'opd');
    }

    /**
     * Polimorfik: Dapatkan model inovasi terkait (academic atau opd)
     */
    public function innovation()
    {
        if ($this->innovation_type === 'academic') {
            return $this->academicInnovation();
        }

        if ($this->innovation_type === 'opd') {
            return $this->opdInnovation();
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | 🔹 ACCESSORS
    |--------------------------------------------------------------------------
    */

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
        if ($this->image_path && Storage::exists($this->image_path)) {
            return Storage::url($this->image_path);
        }
        return asset('images/defaults/kolaborasi-cover.png');
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

    /*
    |--------------------------------------------------------------------------
    | 🔹 MUTATORS
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | 🔹 SCOPES
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | 🔹 CUSTOM HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah user adalah pemilik ide inovasi (academic atau opd)
     */
    public function isOwnedByUser($userId): bool
    {
        if ($this->innovation_type === 'academic') {
            return $this->academicInnovation && $this->academicInnovation->user_id === $userId;
        }

        if ($this->innovation_type === 'opd') {
            return $this->opdInnovation && $this->opdInnovation->user_id === $userId;
        }

        return false;
    }

    /**
     * Cek apakah user adalah pengaju kolaborasi utama (leader)
     */
    public function isLeader($userId): bool
    {
        return $this->user_id === $userId;
    }
}
