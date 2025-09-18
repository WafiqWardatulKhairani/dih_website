<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramPemerintah extends Model
{
    // kasih tau tabelnya sebenernya
    protected $table = 'programs';

    protected $fillable = [
        'title',
        'category',
        'opd',
        'badge',
        'description',
        'image'
    ];
}
