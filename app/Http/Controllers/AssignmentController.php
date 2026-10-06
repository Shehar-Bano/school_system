<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\classe;
use App\Models\ClassesSubject;
use App\Models\Employee;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function assignmentView()
    {
        if (auth()->check() && !auth()->user()->can('academic.assignment.view')) {
            abort(403, 'Unauthorized: You do not have permission to view assignments.');
        }

        $assignments = Assignment::with(['class', 'section', 'subject', 'teacher', 'submissions'])->latest()->get();

        return view('assignment.view', compact('assignments'));
    }

    public function addAssignmentView()
    {
        if (auth()->check() && !auth()->user()->can('academic.assignment.create')) {
            abort(403, 'Unauthorized: You do not have permission to create assignments.');
        }

        $classes = classe::get();
        $sections = Section::get();
        $subjects = ClassesSubject::with('class', 'subject')->get();
        $teachers = Employee::where('status', 1)->orWhereNull('status')->get();

        return view('assignment.add', compact('classes', 'sections', 'subjects', 'teachers'));
    }

    public function assignmentStore(Request $request)
    {
        if (auth()->check() && !auth()->user()->can('academic.assignment.create')) {
            abort(403, 'Unauthorized: You do not have permission to create assignments.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'deadline' => 'required|date',
            'total_marks' => 'nullable|numeric|min:1',
            'teacher_id' => 'nullable|exists:employees,id',
            'assignment' => 'required|file|max:20480',
        ]);

        $uploader = Auth::user();
        $assignment = new Assignment;
        $assignment->uploader = $uploader ? $uploader->name : 'Admin';
        $assignment->title = $request->title;
        $assignment->description = $request->description;
        $assignment->class_id = $request->class_id;
        $assignment->section_id = $request->section_id;
        $assignment->subject_id = $request->subject_id;
        $assignment->teacher_id = $request->teacher_id;
        $assignment->deadline = $request->deadline;
        $assignment->total_marks = $request->total_marks ?? 100;

        $file = $request->file('assignment');
        $assignmentPath = $file->store('Assignments', 'public');
        $assignment->assignment = $assignmentPath;
        $assignment->save();

        return redirect()->route('assignment_show')->with('message', 'Assignment created successfully!');
    }

    public function assignmentDelete($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.assignment.delete')) {
            abort(403, 'Unauthorized: You do not have permission to delete assignments.');
        }

        $assignment = Assignment::findOrFail($id);
        $assignment->delete();

        return redirect()->back()->with('message', 'Assignment Deleted Successfully!');
    }

    public function editAssignmentView($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.assignment.edit')) {
            abort(403, 'Unauthorized: You do not have permission to edit assignments.');
        }

        $assignment = Assignment::with('subject', 'section', 'class', 'teacher')->findOrFail($id);
        $classes = classe::get();
        $sections = Section::get();
        $subjects = Subject::get();
        $teachers = Employee::where('status', 1)->orWhereNull('status')->get();

        return view('assignment.edit', compact('assignment', 'classes', 'sections', 'subjects', 'teachers'));
    }

    public function assignmentUpdate(Request $request, $id)
    {
        if (auth()->check() && !auth()->user()->can('academic.assignment.edit')) {
            abort(403, 'Unauthorized: You do not have permission to update assignments.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'deadline' => 'required|date',
            'total_marks' => 'nullable|numeric|min:1',
            'teacher_id' => 'nullable|exists:employees,id',
            'assignment' => 'nullable|file|max:20480',
        ]);

        $assignment = Assignment::findOrFail($id);
        $assignment->title = $request->title;
        $assignment->description = $request->description;
        $assignment->class_id = $request->class_id;
        $assignment->section_id = $request->section_id;
        $assignment->subject_id = $request->subject_id;
        $assignment->teacher_id = $request->teacher_id ?? $assignment->teacher_id;
        $assignment->deadline = $request->deadline;
        $assignment->total_marks = $request->total_marks ?? $assignment->total_marks ?? 100;

        if ($request->hasFile('assignment')) {
            $file = $request->file('assignment');
            $assignmentPath = $file->store('Assignments', 'public');
            $assignment->assignment = $assignmentPath;
        }

        $assignment->save();

        return redirect()->route('assignment_show')->with('message', 'Assignment Updated Successfully!');
    }

    public function assignmetDetail($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.assignment.detail') && !auth()->user()->can('academic.assignment.view')) {
            abort(403, 'Unauthorized: You do not have permission to view assignment details.');
        }

        $assignment = Assignment::with(['subject', 'section', 'class', 'teacher', 'submissions.student'])->findOrFail($id);
        $trackingStats = $assignment->getTrackingStats();

        return view('assignment.detail', compact('assignment', 'trackingStats'));
    }

    /**
     * Dedicated Assignment Tracking Dashboard for Class & Section Roster
     */
    public function assignmentTracking($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.assignment.view')) {
            abort(403, 'Unauthorized: You do not have permission to view assignment tracking.');
        }

        $assignment = Assignment::with(['class', 'section', 'subject', 'teacher', 'submissions.student'])->findOrFail($id);
        
        // Fetch all students belonging to the target class and section
        $students = Student::where('class_id', $assignment->class_id)
            ->where('section_id', $assignment->section_id)
            ->orderBy('registration', 'asc')
            ->get();

        $submissions = $assignment->submissions->keyBy('student_id');
        $deadline = Carbon::parse($assignment->deadline)->endOfDay();
        $isDeadlinePassed = now()->isAfter($deadline);

        $totalStudents = $students->count();
        $submittedCount = $submissions->count();
        $pendingCount = max(0, $totalStudents - $submittedCount);
        $gradedCount = $submissions->whereNotNull('marks')->count();
        $averageMarks = $gradedCount > 0 ? round($submissions->whereNotNull('marks')->avg('marks'), 1) : 0;
        $submissionRate = $totalStudents > 0 ? round(($submittedCount / $totalStudents) * 100) : 0;

        // Build complete student roster with submission and deadline status
        $roster = $students->map(function ($student) use ($submissions, $deadline, $isDeadlinePassed) {
            $submission = $submissions->get($student->id);
            
            $status = 'pending';
            $statusBadge = 'warning';
            $statusText = 'Pending';

            if ($submission) {
                if ($submission->marks !== null) {
                    $status = 'graded';
                    $statusBadge = 'success';
                    $statusText = 'Graded';
                } elseif ($submission->submitted_at && Carbon::parse($submission->submitted_at)->isAfter($deadline)) {
                    $status = 'late';
                    $statusBadge = 'info';
                    $statusText = 'Submitted (Late)';
                } else {
                    $status = 'submitted';
                    $statusBadge = 'primary';
                    $statusText = 'Submitted (On-Time)';
                }
            } else {
                if ($isDeadlinePassed) {
                    $status = 'overdue';
                    $statusBadge = 'danger';
                    $statusText = 'Overdue / Missing';
                }
            }

            return (object)[
                'student' => $student,
                'submission' => $submission,
                'status' => $status,
                'status_badge' => $statusBadge,
                'status_text' => $statusText,
            ];
        });

        return view('assignment.tracking', compact(
            'assignment',
            'roster',
            'totalStudents',
            'submittedCount',
            'pendingCount',
            'gradedCount',
            'averageMarks',
            'submissionRate',
            'isDeadlinePassed'
        ));
    }

    /**
     * Grade an individual student submission
     */
    public function gradeSubmission(Request $request, $id)
    {
        if (auth()->check() && !auth()->user()->can('academic.assignment.edit') && !auth()->user()->hasRole('superadmin')) {
            abort(403, 'Unauthorized: You do not have permission to grade assignments.');
        }

        $request->validate([
            'marks' => 'required|numeric|min:0',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $submission = AssignmentSubmission::findOrFail($id);
        $submission->marks = $request->marks;
        $submission->feedback = $request->feedback;
        $submission->status = 'graded';
        $submission->graded_by = Auth::user()->name ?? 'Teacher';
        $submission->save();

        return redirect()->back()->with('message', 'Student submission graded successfully!');
    }
}

