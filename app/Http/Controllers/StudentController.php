<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Exam;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    private function getStudentData()
    {
        $student = auth()->user()->student;

        $exams = $student->exams()
            ->with(['subject' => function($q) {
                $q->where('published', true);
            }])
            ->get()
            ->filter(fn($e) => $e->subject !== null)
            ->values();

        // Only count failures in subjects that match the student's own category
        $failedExams = $exams->where('status', 'Fail')
            ->filter(fn($e) => $e->subject->category === $student->category);

        $failedCount = $failedExams->count();

        $resitType = null;
        if ($failedCount === 1) $resitType = 'single';
        elseif ($failedCount > 1) $resitType = 'full';

        return compact('student', 'exams', 'failedExams', 'resitType');
    }

    public function dashboard()
    {
        $student = auth()->user()->student;

        if (!$student) {
            return view('student.no_profile')
                ->with('error', 'Student profile not found.');
        }

        extract($this->getStudentData());

        return view('student.dashboard', compact('student', 'exams', 'failedExams', 'resitType'));
    }

    public function viewResults()
    {
        extract($this->getStudentData());
        return view('student.results', compact('student', 'exams', 'failedExams', 'resitType'));
    }

    public function downloadResult()
    {
        extract($this->getStudentData());
        $pdf = Pdf::loadView('student.results_pdf', compact('student', 'exams', 'failedExams', 'resitType'));
        return $pdf->download('results_' . $student->index_number . '.pdf');
    }

    public function recordExam(Request $request, $studentId)
    {
        $request->validate([
            'subject_id'     => 'required|exists:subjects,id',
            'marks'          => 'nullable|numeric|min:0|max:500',
            'attempt_number' => 'required|integer|min:1|max:3',
        ]);

        $student = Student::findOrFail($studentId);
        $status = is_null($request->marks) ? 'Pending' : ($request->marks >= 400 ? 'Pass' : 'Fail');

        $exam = $student->exams()->create([
            'subject_id'     => $request->subject_id,
            'marks'          => $request->marks,
            'attempt_number' => $request->attempt_number,
            'status'         => $status,
        ]);

        if ($status === 'Fail') {
            $exam->update(['resit_needed' => true]);

            // Count failed subjects in student's own category for this attempt
            $failedInCategory = $student->exams()
                ->where('attempt_number', $exam->attempt_number)
                ->where('status', 'Fail')
                ->whereHas('subject', fn($q) => $q->where('category', $student->category))
                ->count();

            // Only decrement attempts if 2+ failures in category (full resit triggered)
            if ($failedInCategory >= 2 && $student->attempts_left > 0) {
                $student->decrement('attempts_left');
            }
        }

        return back()->with('success', 'Exam result recorded.');
    }
}
