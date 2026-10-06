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

class EmployeeAssignmentController extends Controller
{
    /**
     * Get authenticated teacher instance
     */
    protected function getTeacher()
    {
        return Auth::guard('employee')->user();
    }

    /**
     * Display teacher's assignments
     */
    public function index()
    {
        $teacher = $this->getTeacher();
        if (!$teacher) {
            return redirect()->route('employee.login')->with('error', 'Please login as teacher.');
        }

        // Get section IDs where this employee is incharge
        $inchargeSectionIds = Section::where('employee_id', $teacher->id)->pluck('id')->toArray();

        // Get assignments created by this teacher OR for their incharge sections
        $assignments = Assignment::with(['class', 'section', 'subject', 'submissions'])
            ->where(function ($query) use ($teacher, $inchargeSectionIds) {
                $query->where('teacher_id', $teacher->id)
                      ->orWhere('uploader', $teacher->name)
                      ->orWhereIn('section_id', $inchargeSectionIds);
            })
            ->latest()
            ->get();

        return view('employeeDashboard.assignment.index', compact('teacher', 'assignments'));
    }

    /**
     * Show create assignment form for teacher
     */
    public function create()
    {
        $teacher = $this->getTeacher();
        if (!$teacher) {
            return redirect()->route('employee.login')->with('error', 'Please login as teacher.');
        }

        // Fetch classes, sections, and subjects
        $classes = classe::get();
        $sections = Section::get();
        $subjects = Subject::get();

        return view('employeeDashboard.assignment.create', compact('teacher', 'classes', 'sections', 'subjects'));
    }

    /**
     * Store new assignment created by teacher
     */
    public function store(Request $request)
    {
        $teacher = $this->getTeacher();
        if (!$teacher) {
            return redirect()->route('employee.login')->with('error', 'Please login as teacher.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'deadline' => 'required|date',
            'total_marks' => 'nullable|numeric|min:1',
            'assignment' => 'required|file|max:20480',
        ]);

        $assignment = new Assignment;
        $assignment->uploader = $teacher->name;
        $assignment->teacher_id = $teacher->id;
        $assignment->title = $request->title;
        $assignment->description = $request->description;
        $assignment->class_id = $request->class_id;
        $assignment->section_id = $request->section_id;
        $assignment->subject_id = $request->subject_id;
        $assignment->deadline = $request->deadline;
        $assignment->total_marks = $request->total_marks ?? 100;

        $file = $request->file('assignment');
        $assignmentPath = $file->store('Assignments', 'public');
        $assignment->assignment = $assignmentPath;
        $assignment->save();

        return redirect()->route('employee.assignments')->with('message', 'Assignment created and assigned to students successfully!');
    }

    /**
     * Teacher Assignment Tracking & Student Roster
     */
    public function track($id)
    {
        $teacher = $this->getTeacher();
        if (!$teacher) {
            return redirect()->route('employee.login')->with('error', 'Please login as teacher.');
        }

        $assignment = Assignment::with(['class', 'section', 'subject', 'submissions.student'])->findOrFail($id);

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

        // Build roster
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

        return view('employeeDashboard.assignment.track', compact(
            'teacher',
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
     * Teacher Grades a Student Submission
     */
    public function grade(Request $request, $id)
    {
        $teacher = $this->getTeacher();
        if (!$teacher) {
            return redirect()->route('employee.login')->with('error', 'Please login as teacher.');
        }

        $request->validate([
            'marks' => 'required|numeric|min:0',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $submission = AssignmentSubmission::findOrFail($id);
        $submission->marks = $request->marks;
        $submission->feedback = $request->feedback;
        $submission->status = 'graded';
        $submission->graded_by = $teacher->name;
        $submission->save();

        return redirect()->back()->with('message', 'Student submission graded successfully!');
    }
}
