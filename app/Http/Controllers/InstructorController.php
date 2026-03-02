<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Exam;

class InstructorController extends Controller
{
    // Dashboard shows all subjects assigned to the instructor
    public function dashboard()
    {   
       
        $instructor = auth()->user();
        $subjects = Subject::where('instructor_id', $instructor->id)->get();

        return view('instructor.dashboard', compact('subjects'));
    }

    // Show students for a particular subject
    public function subjectStudents(Subject $subject)
    {
        

        $this->authorize('view', $subject); // make sure instructor owns the subject

       $students = Student::whereHas('exams', function($q) use ($subject){
            $q->where('subject_id', $subject->id);
        })->with(['user', 'exams' => function($q) use ($subject){
            $q->where('subject_id', $subject->id);
        }])->get();

        return view('instructor.subject_students', compact('subject', 'students'));
    }

    // Edit an exam result
    public function editExam(Exam $exam)
    {
        $this->authorize('update', $exam);

        if($exam->submitted_for_approval){
            return back()->with('error', 'Result has been submitted. Cannot edit.');
        }

        return view('instructor.edit_exam', compact('exam'));
    }

    public function updateExam(Request $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        if($exam->submitted_for_approval){
            return back()->with('error', 'Result has been submitted. Cannot edit.');
        }

        $request->validate([
            'marks' => 'nullable|numeric|min:0|max:500',
        ]);

       $exam->marks = $request->marks;
        $exam->status = is_null($request->marks) ? 'Pending' : ($request->marks >= 400 ? 'Pass' : 'Fail');
        $exam->save();

        return back()->with('success', 'Result updated.');
    }

    // Submit final results for approval
    public function submitResults(Subject $subject)
    {
        $this->authorize('update', $subject);

        Exam::where('subject_id', $subject->id)->update(['submitted_for_approval' => true]);
        $subject->update(['results_submitted' => true]);

        return back()->with('success', 'Results submitted for approval. You cannot edit anymore.');
    }
}   