<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
        'exam_id', 'examboard_id', 'approved_by_examboard',
        'approved_by_director', 'examboard_remarks', 'director_remarks'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function examboard()
    {
        return $this->belongsTo(User::class, 'examboard_id');
    }
}
