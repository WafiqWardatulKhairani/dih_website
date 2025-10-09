<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdInnovation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'institution', 
        'category',
        'subcategory',
        'author_name',
        'keywords',
        'purpose',
        'technology_readiness_level',
        'image',
        'document_path',
        'video_url',
        'contact',
        'status',
        'research_duration',
        'rating', 
        'is_verified',
        'innovation_type'
    ];

    // Status constants seperti di akademisi
    const STATUS_DRAFT = 'draft';
    const STATUS_REVIEW = 'review';
    const STATUS_PUBLICATION = 'publication';

    public static function statuses()
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_REVIEW, 
            self::STATUS_PUBLICATION,
        ];
    }
}