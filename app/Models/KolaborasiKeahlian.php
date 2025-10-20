<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KolaborasiKeahlian extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_keahlian';
    
    protected $fillable = [
        'kolaborasi_idea_id', 
        'keahlian'
    ];

    public $timestamps = true;

    /**
     * Relationship dengan ide kolaborasi
     */
    public function idea(): BelongsTo
    {
        return $this->belongsTo(KolaborasiIdea::class, 'kolaborasi_idea_id');
    }

    /**
     * Scope untuk keahlian tertentu
     */
    public function scopeByKeahlian($query, $keahlian)
    {
        return $query->where('keahlian', $keahlian);
    }
}