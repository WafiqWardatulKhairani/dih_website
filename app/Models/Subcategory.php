<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $table = 'subcategories';

    protected $fillable = [
        'category_id',
        'name',
    ];

    /**
     * Relasi: subkategori dimiliki oleh satu kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relasi: subkategori memiliki banyak ide kolaborasi.
     */
    public function kolaborasiIdeas()
    {
        return $this->hasMany(KolaborasiIde::class, 'subcategory_id');
    }
}
