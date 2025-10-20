<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KolaborasiIdea extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_ideas';
    
    protected $fillable = [
        'user_id', 
        'category_id',
        'subcategory_id',
        'judul', 
        'deskripsi_singkat', 
        'latar_belakang',
        'solusi', 
        'estimasi_waktu', 
        'kompleksitas', 
        'dampak', 
        'dokumen_path', 
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    protected $appends = [
        'keahlian_list',
        'partner_list',
        'status_label',
        'nama_kategori',
        'nama_subkategori',
        'kategori_lengkap',
        'can_edit',
        'is_approved',
        'has_project',
        'status_color'
    ];

    // Constants for status
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    /**
     * Relationship dengan user yang membuat ide
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship dengan kategori
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relationship dengan subkategori
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    /**
     * Relationship dengan keahlian yang dibutuhkan
     */
    public function keahlian(): HasMany
    {
        return $this->hasMany(KolaborasiKeahlian::class, 'kolaborasi_idea_id');
    }

    /**
     * Relationship dengan partner yang diinginkan
     */
    public function partner(): HasMany
    {
        return $this->hasMany(KolaborasiPartner::class, 'kolaborasi_idea_id');
    }

    /**
     * Relationship dengan project (jika ide disetujui)
     */
    public function project(): HasOne
    {
        return $this->hasOne(KolaborasiProject::class, 'kolaborasi_idea_id');
    }

    /**
     * Scope untuk status submitted
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', self::STATUS_SUBMITTED);
    }

    /**
     * Scope untuk status approved
     */
    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    /**
     * Scope untuk status in progress
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    /**
     * Scope untuk ide yang aktif (bukan draft atau rejected)
     */
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [self::STATUS_DRAFT, self::STATUS_REJECTED]);
    }

    /**
     * Scope untuk ide berdasarkan kategori
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope untuk ide berdasarkan subkategori
     */
    public function scopeBySubcategory($query, $subcategoryId)
    {
        return $query->where('subcategory_id', $subcategoryId);
    }

    /**
     * Scope untuk ide milik user tertentu
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk ide dengan kategori dan subkategori
     */
    public function scopeWithCategoryInfo($query)
    {
        return $query->with(['category', 'subcategory']);
    }

    /**
     * Accessor untuk daftar keahlian sebagai array
     */
    public function getKeahlianListAttribute(): array
    {
        return $this->keahlian->pluck('keahlian')->toArray();
    }

    /**
     * Accessor untuk daftar partner sebagai array
     */
    public function getPartnerListAttribute(): array
    {
        return $this->partner->pluck('partner')->toArray();
    }

    /**
     * Accessor untuk label status
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_SUBMITTED => 'Terkirim',
            self::STATUS_UNDER_REVIEW => 'Dalam Review',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATUS_IN_PROGRESS => 'Dalam Progress',
            self::STATUS_COMPLETED => 'Selesai',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Accessor untuk nama kategori
     */
    public function getNamaKategoriAttribute(): string
    {
        return $this->category ? $this->category->name : 'Tidak ada kategori';
    }

    /**
     * Accessor untuk nama subkategori
     */
    public function getNamaSubkategoriAttribute(): ?string
    {
        return $this->subcategory ? $this->subcategory->name : null;
    }

    /**
     * Accessor untuk kategori lengkap (kategori + subkategori)
     */
    public function getKategoriLengkapAttribute(): string
    {
        $kategori = $this->nama_kategori;
        if ($this->nama_subkategori) {
            $kategori .= ' - ' . $this->nama_subkategori;
        }
        return $kategori;
    }

    /**
     * Accessor untuk warna status
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT => 'gray',
            self::STATUS_SUBMITTED => 'blue',
            self::STATUS_UNDER_REVIEW => 'yellow',
            self::STATUS_APPROVED => 'green',
            self::STATUS_REJECTED => 'red',
            self::STATUS_IN_PROGRESS => 'purple',
            self::STATUS_COMPLETED => 'indigo',
            default => 'gray'
        };
    }

    /**
     * Check jika ide bisa diedit
     */
    public function getCanEditAttribute(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_SUBMITTED]);
    }

    /**
     * Check jika ide sudah disetujui
     */
    public function getIsApprovedAttribute(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check jika ide sudah memiliki project
     */
    public function getHasProjectAttribute(): bool
    {
        return $this->project !== null;
    }

    /**
     * Check jika subkategori valid (milik kategori yang dipilih)
     */
    public function isSubcategoryValid(): bool
    {
        if (!$this->subcategory_id) {
            return true;
        }

        return $this->subcategory && $this->subcategory->category_id === $this->category_id;
    }

    /**
     * Method untuk mengupdate status ide
     */
    public function updateStatus(string $status): bool
    {
        $validStatuses = [
            self::STATUS_DRAFT,
            self::STATUS_SUBMITTED,
            self::STATUS_UNDER_REVIEW,
            self::STATUS_APPROVED,
            self::STATUS_REJECTED,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED
        ];

        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $this->status = $status;
        
        if ($status === self::STATUS_SUBMITTED && !$this->submitted_at) {
            $this->submitted_at = now();
        } elseif ($status === self::STATUS_APPROVED && !$this->approved_at) {
            $this->approved_at = now();
        } elseif ($status === self::STATUS_COMPLETED && !$this->completed_at) {
            $this->completed_at = now();
        }

        return $this->save();
    }

    /**
     * Method untuk menambahkan keahlian
     */
    public function addKeahlian(array $keahlianList): void
    {
        foreach ($keahlianList as $keahlian) {
            $this->keahlian()->create(['keahlian' => $keahlian]);
        }
    }

    /**
     * Method untuk menambahkan partner
     */
    public function addPartner(array $partnerList): void
    {
        foreach ($partnerList as $partner) {
            $this->partner()->create(['partner' => $partner]);
        }
    }

    /**
     * Method untuk sync keahlian
     */
    public function syncKeahlian(array $keahlianList): void
    {
        $this->keahlian()->delete();
        if (!empty($keahlianList)) {
            $this->addKeahlian($keahlianList);
        }
    }

    /**
     * Method untuk sync partner
     */
    public function syncPartner(array $partnerList): void
    {
        $this->partner()->delete();
        if (!empty($partnerList)) {
            $this->addPartner($partnerList);
        }
    }

    /**
     * Method untuk mendapatkan subkategori yang tersedia berdasarkan kategori saat ini
     */
    public function getAvailableSubcategories()
    {
        if (!$this->category_id) {
            return collect();
        }

        return Subcategory::where('category_id', $this->category_id)->get();
    }

    /**
     * Method untuk validasi kategori dan subkategori
     */
    public function validateCategoryRelations(): bool
    {
        if (!Category::where('id', $this->category_id)->exists()) {
            return false;
        }

        if ($this->subcategory_id && !Subcategory::where('id', $this->subcategory_id)
            ->where('category_id', $this->category_id)->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Boot method untuk model
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($idea) {
            if (!$idea->validateCategoryRelations()) {
                throw new \Exception('Invalid category or subcategory relationship.');
            }
        });

        static::deleting(function ($idea) {
            $idea->keahlian()->delete();
            $idea->partner()->delete();
        });
    }
}