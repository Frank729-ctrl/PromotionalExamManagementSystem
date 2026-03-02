<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Student;

class DirectorController extends Controller
{
    public function dashboard()
    {
        $subjects = Subject::with(['exams.student', 'instructor'])->get();

        // Overall stats
        $totalStudents = Student::count();
        $totalExams = Exam::count();
        $totalPassed = Exam::where('status', 'Pass')->count();
        $totalFailed = Exam::where('status', 'Fail')->count();
        $totalPending = Exam::where('status', 'Pending')->count();

        // Per subject breakdown
        $subjectStats = Subject::with('exams')->get()->map(function($subject) {
            $total = $subject->exams->count();
            $passed = $subject->exams->where('status', 'Pass')->count();
            $failed = $subject->exams->where('status', 'Fail')->count();
            return [
                'name' => $subject->name,
                'total' => $total,
                'passed' => $passed,
                'failed' => $failed,
                'pass_rate' => $total > 0 ? round(($passed / $total) * 100) : 0,
            ];
        });

        // Level breakdown
        $levelBreakdown = Student::selectRaw('level, count(*) as total')
            ->groupBy('level')->pluck('total', 'level');

        // Category breakdown
        $categoryBreakdown = Student::selectRaw('category, count(*) as total')
            ->groupBy('category')->pluck('total', 'category');

        return view('director.dashboard', compact(
            'subjects', 'totalStudents', 'totalExams',
            'totalPassed', 'totalFailed', 'totalPending',
            'subjectStats', 'levelBreakdown', 'categoryBreakdown'
        ));
    }

    public function reviewSubject(Subject $subject)
    {
        $exams = Exam::where('subject_id', $subject->id)
            ->with(['student.user'])
            ->get();

        return view('director.review_subject', compact('subject', 'exams'));
    }

    public function publish(Request $request, Subject $subject)
    {
        $request->validate([
            'director_remarks' => 'nullable|string|max:1000',
        ]);

        $subject->update([
            'published' => true,
            'director_remarks' => $request->director_remarks,
        ]);

        return back()->with('success', 'Results published to student portal.');
    }
}
