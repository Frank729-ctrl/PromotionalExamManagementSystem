<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'subject_id', 'marks', 'attempt_number',
        'status', 'submitted', 'submitted_for_approval', 'resit_needed'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function approval()
    {
        return $this->hasOne(Approval::class);
    }
}
