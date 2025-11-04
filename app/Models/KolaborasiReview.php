<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KolaborasiReview extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_reviews';

    protected $fillable = [
        'kolaborasi_id',          // ID kolaborasi
        'kolaborasi_project_id',  // ID task terkait (opsional)
        'user_id',                // user yang direview / target
        'reviewer_id',            // user yang memberi review
        'komentar',               // komentar review
        'status',                 // status task (opsional)
        'rating',                 // rating 1-5
        'versi',                  // opsional
        'reviewed_at',            // waktu review
    ];

    /**
     * Task terkait review
     */
    public function task()
    {
        return $this->belongsTo(KolaborasiTask::class, 'kolaborasi_project_id');
    }

    /**
     * User yang dinilai / target review
     */
    public function reviewee()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id')->withDefault();
    }

    /**
     * User yang memberi review
     */
    public function reviewer()
    {
        return $this->belongsTo(\App\Models\User::class, 'reviewer_id')->withDefault();
    }
}
