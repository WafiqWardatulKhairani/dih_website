<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class KolaborasiTask extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'kolaborasi_tasks';

    // Mass assignable attributes
    protected $fillable = [
        'kolaborasi_id',   // ID kolaborasi induk (KolaborasiIde)
        'title',           // Judul tugas
        'description',     // Deskripsi tugas
        'assigned_to',     // User ID yang ditugaskan
        'deadline',        // Tanggal deadline
        'status',          // todo, in_progress, done
    ];

    // Casting tipe data
    protected $casts = [
        'deadline' => 'datetime',
    ];

    // Default attributes
    protected $attributes = [
        'status' => 'todo', // Default status ketika task baru dibuat
    ];

    /*
    |--------------------------------------------------------------------------
    | 🔹 RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Relasi ke kolaborasi induk (KolaborasiIde)
    public function kolaborasi()
    {
        return $this->belongsTo(KolaborasiIde::class, 'kolaborasi_id');
    }

    // Relasi ke user yang ditugaskan (assignee)
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to')->withDefault([
            'name' => 'Belum ditugaskan'
        ]);
    }

    // Relasi ke progress (setiap laporan penyelesaian dari task ini)
    public function progress()
    {
        return $this->hasMany(KolaborasiProgress::class, 'task_id');
    }

    // Relasi ke dokumen yang diunggah untuk task ini
    public function documents()
    {
        return $this->hasMany(KolaborasiDocument::class, 'task_id');
    }

    // Relasi ke review yang diberikan pada task ini
    public function review()
    {
        return $this->hasOne(KolaborasiReview::class, 'kolaborasi_project_id');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔹 ACCESSORS & HELPERS
    |--------------------------------------------------------------------------
    */

    // Cek apakah task sudah melewati deadline
    public function getIsOverdueAttribute()
    {
        return $this->deadline && $this->status !== 'done' && $this->deadline->isPast();
    }

    // Hitung sisa hari menuju deadline
    public function getRemainingDaysAttribute()
    {
        if (!$this->deadline) return null;
        return Carbon::now()->diffInDays($this->deadline, false);
    }

    // Ambil warna badge status untuk UI
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'todo' => 'gray',
            'in_progress' => 'blue',
            'done' => 'green',
            default => 'gray',
        };
    }

    // Ambil label status untuk UI
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'todo' => 'Belum Dikerjakan',
            'in_progress' => 'Sedang Dikerjakan',
            'done' => 'Selesai',
            default => ucfirst($this->status),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | 🔹 MODEL EVENTS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        // Pastikan status default 'todo' jika belum diisi
        static::creating(function ($task) {
            if (empty($task->status)) {
                $task->status = 'todo';
            }
        });
    }
}
