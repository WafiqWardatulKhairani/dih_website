<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KolaborasiProgress extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_progress';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'kolaborasi_id',  // id kolaborasi
        'task_id',        // id task terkait (nullable)
        'user_id',        // id user yang membuat progress
        'deskripsi',      // catatan / deskripsi progress
        'status',         // status: todo, in-progress, done
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke ide kolaborasi
     */
    public function kolaborasi()
    {
        return $this->belongsTo(KolaborasiIde::class, 'kolaborasi_id');
    }

    /**
     * Relasi ke task kolaborasi
     */
    public function task()
    {
        return $this->belongsTo(KolaborasiTask::class, 'task_id');
    }

    /**
     * Relasi ke user yang membuat progress
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id')->withDefault();
    }

    /**
     * Relasi ke dokumen lampiran progress
     * Menggunakan kolom progress_id yang baru ditambahkan di tabel kolaborasi_documents
     */
    public function documents()
    {
        return $this->hasMany(KolaborasiDocument::class, 'progress_id', 'id');
    }
}
