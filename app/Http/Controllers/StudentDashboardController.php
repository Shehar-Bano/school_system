<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Result;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentFee;
use App\Models\TimeTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('student')->user();
        if (!$user) {
            return redirect()->route('student.login')->with('error', 'Please log in to access your student dashboard.');
        }

        $student = Student::with(['class', 'section'])->find($user->id);

        // Notifications
        $unreadNotifications = $student->unreadNotifications ?? collect();
        $unreadNotificationCount = $unreadNotifications->count();

        // Attendance stats for current year
        $currentYear = now()->year;
        $studentAttendance = StudentAttendance::where('student_id', $student->id)
            ->whereYear('date', $currentYear)
            ->get();

        $totalDays = $studentAttendance->count();
        $totalPresent = $studentAttendance->where('status', 'present')->count();
        $totalAbsent = $studentAttendance->where('status', 'absent')->count();
        $totalLeave = $studentAttendance->where('status', 'leave')->count();
        $totalLate = $studentAttendance->whereIn('status', ['late', 'excused_late'])->count();
        
        $attendancePercentage = $totalDays > 0
            ? ($totalPresent / $totalDays) * 100
            : 0;

        // Current Month Attendance
        $currentMonth = now()->month;
        $monthAttendance = StudentAttendance::where('student_id', $student->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->get();
        $monthPresent = $monthAttendance->where('status', 'present')->count();
        $monthAbsent = $monthAttendance->where('status', 'absent')->count();
        $monthLeave = $monthAttendance->where('status', 'leave')->count();

        // Assignments
        $assignments = Assignment::with(['subject', 'teacher', 'submissions' => function ($q) use ($student) {
            $q->where('student_id', $student->id);
        }])
        ->where('class_id', $student->class_id)
        ->where('section_id', $student->section_id)
        ->latest()
        ->take(4)
        ->get();

        $totalAssignmentsCount = Assignment::where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->count();
            
        $submittedAssignmentsCount = AssignmentSubmission::where('student_id', $student->id)->count();
        $pendingAssignmentsCount = max(0, $totalAssignmentsCount - $submittedAssignmentsCount);

        // Today's Timetable / Schedule
        $todayDay = strtolower(now()->format('l'));
        $todayTimetable = TimeTable::with(['subject', 'teacher'])
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->where('day', $todayDay)
            ->orderBy('start_time')
            ->get();

        // If today has no classes (e.g. Sunday/weekend), fetch week preview
        $weekTimetableCount = TimeTable::where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->count();

        // Recent Exam Results
        $recentResults = Result::with(['subject', 'exam'])
            ->where('student_id', $student->id)
            ->latest()
            ->take(4)
            ->get();

        // Fee summary
        $studentFee = StudentFee::where('student_id', $student->id)->first();

        return view('StudentDashboard.dashboard', compact(
            'student',
            'studentAttendance',
            'totalPresent',
            'totalAbsent',
            'totalLeave',
            'totalLate',
            'monthPresent',
            'monthAbsent',
            'monthLeave',
            'attendancePercentage',
            'unreadNotificationCount',
            'unreadNotifications',
            'assignments',
            'totalAssignmentsCount',
            'submittedAssignmentsCount',
            'pendingAssignmentsCount',
            'todayTimetable',
            'weekTimetableCount',
            'recentResults',
            'studentFee'
        ));
    }
}
