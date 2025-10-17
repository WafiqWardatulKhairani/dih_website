<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KolaborasiPartner extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_partner';
    
    protected $fillable = [
        'kolaborasi_idea_id', 
        'partner'
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
     * Scope untuk partner tertentu
     */
    public function scopeByPartner($query, $partner)
    {
        return $query->where('partner', $partner);
    }
}