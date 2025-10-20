<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KolaborasiReview extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_reviews';
    
    protected $fillable = [
        'kolaborasi_project_id', 'user_id', 'judul', 'komentar',
        'tipe', 'status', 'versi'
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(KolaborasiProject::class, 'kolaborasi_project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeProgressReviews($query)
    {
        return $query->where('tipe', 'progress_review');
    }

    public function scopePending($query)
    {
        return $this->where('status', 'pending');
    }
}