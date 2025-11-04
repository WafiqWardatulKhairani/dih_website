<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KolaborasiDocument extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_documents';

    protected $fillable = [
        'kolaborasi_id',
        'progress_id',    // tambahkan agar bisa diisi mass assignment
        'title',
        'file_name',      // nama file tersimpan
        'file_path',      // path di storage
        'file_type',
        'category',       // teknis, legal, output, internal, lampiran
        'visibility',     // public, member-only, owner-only
        'uploaded_by',
    ];

    /**
     * Relasi ke kolaborasi ide
     */
    public function kolaborasi()
    {
        return $this->belongsTo(KolaborasiIde::class, 'kolaborasi_id');
    }

    /**
     * Relasi ke progress yang terkait (opsional)
     */
    public function progress()
    {
        return $this->belongsTo(KolaborasiProgress::class, 'progress_id');
    }

    /**
     * Relasi ke user yang mengupload dokumen
     */
    public function uploader()
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by')->withDefault();
    }
}
