namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaborationRequest extends Model
{
    use HasFactory;

    protected $fillable = ['innovation_id', 'user_id', 'message', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function innovation() {
        return $this->belongsTo(AcademicInnovation::class);
    }
}
