<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'category', 'instructor_id', 'results_submitted', 'examboard_approved', 'sent_to_director', 'published', 'director_remarks'];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
