<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{   use HasFactory;

    protected $fillable = [
        'user_id', 'level', 'category', 'index_number', 'attempts_left'
    ];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
