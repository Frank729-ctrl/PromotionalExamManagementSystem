<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exam;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    /**
     * Display student dashboard with exam summary
     */
    public function dashboard()
    {
        $student = auth()->user()->student;
        $exams = $student->exams()->with('subject')->get();

        return view('student.dashboard', compact('student', 'exams'));
    }

    /**
     * Record an exam result (called by instructor)
     */
    public function recordExam(Request $request, $studentId)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'marks' => 'required|numeric|min:0|max:500',
            'attempt_number' => 'required|integer|min:1|max:3',
        ]);

        $student = Student::findOrFail($studentId);

        $exam = $student->exams()->create([
            'subject_id' => $request->subject_id,
            'marks' => $request->marks,
            'attempt_number' => $request->attempt_number,
        ]);

        // Apply exam rules
        if ($exam->marks >= 400) {
            $exam->passed = true;
            $exam->resit_needed = false;
        } else {
            $exam->passed = false;

            // Count failed subjects in this attempt
            $failedSubjectsCount = $student->exams()
                ->where('attempt_number', $exam->attempt_number)
                ->where('passed', false)
                ->count();

            // If more than one failed subject, resit entire exam
            $exam->resit_needed = $failedSubjectsCount > 1;

            // Decrease attempts left
            if ($student->attempts_left > 0) {
                $student->attempts_left -= 1;
                $student->save();
            }
        }

        $exam->save();

        return back()->with('success', 'Exam result recorded successfully.');
    }

    /**
     * View all student exam results
     */
    public function viewResults()
    {
        $student = auth()->user()->student;
        $exams = $student->exams()->with('subject')->get();

        return view('student.results', compact('student', 'exams'));
    }

    /**
     * Download exam results as PDF
     */
    public function downloadResult()
    {
        $student = auth()->user()->student;
        $exams = $student->exams()->with('subject')->get();

        $pdf = Pdf::loadView('student.results_pdf', compact('student', 'exams'));

        return $pdf->download('exam_results_' . $student->index_number . '.pdf');
    }
}
