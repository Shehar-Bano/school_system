<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAssignmentController extends Controller
{
    /**
     * Get authenticated student
     */
    protected function getStudent()
    {
        return Auth::guard('student')->user();
    }

    /**
     * Display list of assignments assigned to student's class and section
     */
    public function index()
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->route('student.login')->with('error', 'Please log in first.');
        }

        // Fetch assignments for this student's class & section
        $assignments = Assignment::with(['class', 'section', 'subject', 'teacher', 'submissions' => function ($q) use ($student) {
            $q->where('student_id', $student->id);
        }])
        ->where('class_id', $student->class_id)
        ->where('section_id', $student->section_id)
        ->latest()
        ->get();

        $totalAssigned = $assignments->count();
        $submittedCount = 0;
        $pendingCount = 0;
        $gradedCount = 0;

        foreach ($assignments as $assignment) {
            $userSubmission = $assignment->submissions->first();
            $assignment->user_submission = $userSubmission;

            $deadline = Carbon::parse($assignment->deadline)->endOfDay();
            $isDeadlinePassed = now()->isAfter($deadline);
            $assignment->is_deadline_passed = $isDeadlinePassed;

            if ($userSubmission) {
                $submittedCount++;
                if ($userSubmission->marks !== null) {
                    $gradedCount++;
                }
            } else {
                $pendingCount++;
            }
        }

        return view('StudentDashboard.Profile.assignments', compact(
            'student',
            'assignments',
            'totalAssigned',
            'submittedCount',
            'pendingCount',
            'gradedCount'
        ));
    }

    /**
     * View assignment detail and submission portal for student
     */
    public function detail($id)
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->route('student.login')->with('error', 'Please log in first.');
        }

        $assignment = Assignment::with(['class', 'section', 'subject', 'teacher'])
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->findOrFail($id);

        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $student->id)
            ->first();

        $deadline = Carbon::parse($assignment->deadline)->endOfDay();
        $isDeadlinePassed = now()->isAfter($deadline);

        return view('StudentDashboard.Profile.assignment_detail', compact(
            'student',
            'assignment',
            'submission',
            'deadline',
            'isDeadlinePassed'
        ));
    }

    /**
     * Submit assignment response
     */
    public function submit(Request $request, $id)
    {
        $student = $this->getStudent();
        if (!$student) {
            return redirect()->route('student.login')->with('error', 'Please log in first.');
        }

        $assignment = Assignment::where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->findOrFail($id);

        $request->validate([
            'submission_file' => 'nullable|file|max:20480',
            'submission_text' => 'nullable|string|max:5000',
        ]);

        if (!$request->hasFile('submission_file') && empty($request->submission_text)) {
            return redirect()->back()->withErrors(['submission_file' => 'Please upload a submission file or write your assignment solution notes.'])->withInput();
        }

        $deadline = Carbon::parse($assignment->deadline)->endOfDay();
        $isLate = now()->isAfter($deadline);

        $submission = AssignmentSubmission::firstOrNew([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
        ]);

        if ($request->hasFile('submission_file')) {
            $file = $request->file('submission_file');
            $filePath = $file->store('AssignmentSubmissions', 'public');
            $submission->submission_file = $filePath;
        }

        if ($request->filled('submission_text')) {
            $submission->submission_text = $request->submission_text;
        }

        $submission->submitted_at = now();
        $submission->status = $isLate ? 'late' : 'submitted';
        $submission->save();

        $msg = $isLate 
            ? 'Assignment submitted (Late). Note: Deadline has passed.' 
            : 'Assignment submitted successfully on time!';

        return redirect()->route('student.assignment.detail', ['id' => $assignment->id])->with('message', $msg);
    }
}
