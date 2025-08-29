<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicInnovation extends Model
{
    use HasFactory;

    protected $table = 'academic_innovations';

    protected $fillable = [
        'title',
        'category',
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
}
