<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicInnovation extends Model
{
    use HasFactory;

    protected $table = 'academic_innovations';

    /**
     * Kolom yang bisa diisi massal
     */
    protected $fillable = [
        'title',
        'category',
        'subcategory', // tambahkan ini agar subkategori tersimpan
        'keywords',
        'abstract',
        'description',
        'purpose',
        'technology_readiness_level',
        'image_path',
        'document_path',
        'video_url',
        'author_name',
        'institution',
        'contact',
        'status',
        'copyright_status',
        'user_id',
    ];

    /** ==========================
     *   STATUS CONSTANTS
     *  ========================== */
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLICATION = 'publication';

    /**
     * Helper untuk validasi Rule::in(AcademicInnovation::statuses())
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PUBLICATION,
        ];
    }

    /** ==========================
     *   RELATIONS
     *  ========================== */

    /**
     * Hubungan ke User (pemilik inovasi)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hubungan ke Diskusi
     */
    public function discussions()
    {
        return $this->morphMany(Discussion::class, 'discussionable');
    }
}
