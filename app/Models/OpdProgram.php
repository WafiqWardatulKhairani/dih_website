<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description', 
        'opd_name',
        'category',
        'status',
        'start_date',
        'end_date',
        'budget',
        'progress',
        'image'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2'
    ];
}