<?php

namespace App\Policies;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExamPolicy
{
    public function update(User $user, Exam $exam): bool
{
    return $user->id == $exam->subject->instructor_id;
}

    // Optional: view method if you ever authorize viewing exams
}