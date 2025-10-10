<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Innovation extends Model
{
    // isi kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'title',
        'category',
        'subcategory',
        'author_name',
        'institution',
        'keywords',
        'description',
        'purpose',
        'technology_readiness_level',
        'image_path',
        'document_path',
        'video_url',
        'contact',
        'status',
        'user_id',
    ];

    // Status constants
    public const STATUS_DRAFT = 'Draft';
    public const STATUS_PUBLICATION = 'Publication';

    public static function statuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PUBLICATION,
        ];
    }
}
