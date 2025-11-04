<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    /**
     * Relasi: satu kategori memiliki banyak subkategori.
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }

    /**
     * Relasi: satu kategori memiliki banyak ide kolaborasi.
     */
    public function kolaborasiIdeas()
    {
        return $this->hasMany(KolaborasiIde::class, 'category_id');
    }
}
