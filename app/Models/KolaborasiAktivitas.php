<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KolaborasiAktivitas extends Model
{
    use HasFactory;

    protected $table = 'kolaborasi_aktivitas';
    
    protected $fillable = [
        'kolaborasi_project_id', 'user_id', 'aksi', 'deskripsi',
        'target_type', 'target_id'
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

    // Method to log activity
    public static function logActivity($projectId, $userId, $action, $description, $targetType = null, $targetId = null)
    {
        return self::create([
            'kolaborasi_project_id' => $projectId,
            'user_id' => $userId,
            'aksi' => $action,
            'deskripsi' => $description,
            'target_type' => $targetType,
            'target_id' => $targetId,
        ]);
    }
}