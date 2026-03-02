<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Approval;
use App\Models\Student;

class ExamBoardController extends Controller
{
    public function dashboard()
    {
        $subjects = Subject::with(['exams.student'])->get();

        // Stats for charts
        $levelBreakdown = Student::selectRaw('level, count(*) as total')
            ->groupBy('level')->pluck('total', 'level');

        $categoryBreakdown = Student::selectRaw('category, count(*) as total')
            ->groupBy('category')->pluck('total', 'category');

        $passRates = Subject::with('exams')->get()->map(function($subject) {
            $total = $subject->exams->count();
            $passed = $subject->exams->where('status', 'Pass')->count();
            return [
                'name' => $subject->name,
                'pass_rate' => $total > 0 ? round(($passed / $total) * 100) : 0,
                'total' => $total,
            ];
        });

        return view('examboard.dashboard', compact(
            'subjects', 'levelBreakdown', 'categoryBreakdown', 'passRates'
        ));
    }

    public function reviewSubject(Subject $subject)
    {
        $exams = Exam::where('subject_id', $subject->id)
            ->with(['student.user', 'approval'])
            ->get();

        return view('examboard.review_subject', compact('subject', 'exams'));
    }

    public function approve(Request $request, Subject $subject)
    {
        $request->validate([
            'remarks' => 'nullable|string|max:1000',
        ]);

        Exam::where('subject_id', $subject->id)->each(function($exam) use ($request) {
            Approval::updateOrCreate(
                ['exam_id' => $exam->id],
                [
                    'examboard_id' => auth()->id(),
                    'approved_by_examboard' => true,
                    'examboard_remarks' => $request->remarks,
                ]
            );
        });

        $subject->update(['examboard_approved' => true, 'sent_to_director' => false]);

        return back()->with('success', 'Subject results approved.');
    }

    public function disapprove(Request $request, Subject $subject)
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        Exam::where('subject_id', $subject->id)->each(function($exam) use ($request) {
            Approval::updateOrCreate(
                ['exam_id' => $exam->id],
                [
                    'examboard_id' => auth()->id(),
                    'approved_by_examboard' => false,
                    'examboard_remarks' => $request->remarks,
                ]
            );
            // Unlock exams so instructor can re-edit
            $exam->update(['submitted_for_approval' => false]);
        });

        $subject->update([
            'examboard_approved' => false,
            'results_submitted' => false,
        ]);

        return back()->with('success', 'Results disapproved. Instructor can now re-edit.');
    }

    public function sendToDirector(Subject $subject)
    {
        if (!$subject->examboard_approved) {
            return back()->with('error', 'You must approve the results before sending to Director.');
        }

        $subject->update(['sent_to_director' => true]);

        return back()->with('success', 'Results sent to Director General for publication.');
    }
}
