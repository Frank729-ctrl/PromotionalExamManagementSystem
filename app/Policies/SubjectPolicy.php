<?php

namespace App\Policies;

use App\Models\Subject;
use App\Models\User;           // or whatever your User model is
use Illuminate\Auth\Access\Response;

class SubjectPolicy
{
    // SubjectPolicy.php
    public function view(User $user, Subject $subject): bool
    {
        return $user->id == $subject->instructor_id; // == not ===
    }

    public function update(User $user, Subject $subject): bool
    {
        return $user->id == $subject->instructor_id;
    }
    // You can add more methods like create, delete if needed
}