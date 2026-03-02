<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ExamBoardController;
use App\Http\Controllers\DirectorController;

// Public welcome page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route for authenticated users
Route::middleware(['auth', 'verified'])->group(function () {

    // General /dashboard route redirects based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('student')) {
            return redirect()->route('student.dashboard');
        } elseif ($user->hasRole('instructor')) {
            return redirect()->route('instructor.dashboard');
        } elseif ($user->hasRole('examboard')) {
            return redirect()->route('examboard.dashboard');
        } elseif ($user->hasRole('director')) {
            return redirect()->route('director.dashboard');
        } else {
            return view('dashboard'); // fallback
        }
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================== STUDENT ROUTES =====================
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function() {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/results', [StudentController::class, 'viewResults'])->name('student.results');
    Route::get('/results/download', [StudentController::class, 'downloadResult'])->name('student.results.download');
    Route::post('/exam/{studentId}', [StudentController::class, 'recordExam'])->name('student.exam.record');
});

// ===================== INSTRUCTOR ROUTES =====================
Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->group(function() {
    Route::get('/dashboard', [InstructorController::class, 'dashboard'])->name('instructor.dashboard');
    Route::get('/students/{subject}', [InstructorController::class, 'subjectStudents'])->name('instructor.subject.students');
    Route::get('/exam/{exam}/edit', [InstructorController::class, 'editExam'])->name('instructor.exam.edit');
    Route::post('/exam/{exam}', [InstructorController::class, 'updateExam'])->name('instructor.exam.update');
    Route::post('/subject/{subject}/submit', [InstructorController::class, 'submitResults'])->name('instructor.subject.submit');
});

// ===================== EXAM BOARD ROUTES =====================
Route::middleware(['auth', 'role:examboard'])->prefix('examboard')->group(function() {
    Route::get('/dashboard', [ExamBoardController::class, 'dashboard'])->name('examboard.dashboard');
    Route::get('/subject/{subject}', [ExamBoardController::class, 'reviewSubject'])->name('examboard.review');
    Route::post('/subject/{subject}/approve', [ExamBoardController::class, 'approve'])->name('examboard.approve');
    Route::post('/subject/{subject}/disapprove', [ExamBoardController::class, 'disapprove'])->name('examboard.disapprove');
    Route::post('/subject/{subject}/send-to-director', [ExamBoardController::class, 'sendToDirector'])->name('examboard.send_to_director');
});

// ===================== DIRECTOR ROUTES =====================
Route::middleware(['auth', 'role:director'])->prefix('director')->group(function() {
    Route::get('/dashboard', [DirectorController::class, 'dashboard'])->name('director.dashboard');
    Route::get('/subject/{subject}', [DirectorController::class, 'reviewSubject'])->name('director.review');
    Route::post('/subject/{subject}/publish', [DirectorController::class, 'publish'])->name('director.publish');
});

require __DIR__.'/auth.php';
