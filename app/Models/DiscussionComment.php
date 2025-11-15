<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AcademicInnovation;

class DiscussionComment extends Model
{
    use HasFactory;

    protected $fillable = ['innovation_id', 'user_id', 'content'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function innovation() {
        return $this->belongsTo(AcademicInnovation::class);
    }
}
