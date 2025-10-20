<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KolaborasiTugas extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_tugas';
    
    protected $fillable = [
        'kolaborasi_project_id', 'judul', 'deskripsi', 'assignee_id',
        'created_by', 'status', 'prioritas', 'deadline', 'estimasi_jam'
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(KolaborasiProject::class, 'kolaborasi_project_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeTodo($query)
    {
        return $query->where('status', 'todo');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('prioritas', 'high')->orWhere('prioritas', 'urgent');
    }
}