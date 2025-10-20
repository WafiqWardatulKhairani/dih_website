<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inovasi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'kategori_id',
        'subkategori_id',
        'user_id',
        'trl_level',
        'is_popular',
        'is_new',
        'is_ready',
        'is_collaborating',
        'is_implemented',
        'total_dilihat',
        'total_komentar'
    ];
    
    protected $casts = [
        'is_popular' => 'boolean',
        'is_new' => 'boolean',
        'is_ready' => 'boolean',
        'is_collaborating' => 'boolean',
        'is_implemented' => 'boolean'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    
    public function subkategori()
    {
        return $this->belongsTo(Subkategori::class);
    }
    
    public function komentar()
    {
        return $this->hasMany(Komentar::class);
    }
    
    public function kolaborasi()
    {
        return $this->hasMany(Kolaborasi::class);
    }
}