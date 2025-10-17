<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'discussionable_id',
        'discussionable_type',
        'title',
        'content',
    ];

    // Relasi ke user (yang buat diskusi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Polymorphic relation ke inovasi (akademisi atau opd)
    public function discussionable()
    {
        return $this->morphTo();
    }

    // Relasi ke balasan diskusi
    public function replies()
    {
        return $this->hasMany(DiscussionReply::class);
    }
}
