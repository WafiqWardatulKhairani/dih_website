<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class DihAdmin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'dih_admins';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
