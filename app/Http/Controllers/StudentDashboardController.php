<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = auth()->guard('student')->user();

        // Fetch unread notifications for the logged-in employee
        $unreadNotifications = $student->unreadNotifications;
        $unreadNotificationCount=$student->unreadNotifications->count();
   
        $studentId = auth()->guard('student')->user()->id;
        $currentYear = now()->year;
        $studentAttendance = StudentAttendance::where('student_id', $studentId)
            ->whereYear('date', $currentYear)
            ->get();
        $totalDays = $studentAttendance->count();
        $totalPresent = $studentAttendance->where('status', 'present')->count();
        $totalAbsent = $studentAttendance->where('status', 'absent')->count();
        $totalLeave = $studentAttendance->where('status', 'leave')->count();
        $attendancePercentage = $totalDays > 0
            ? ($totalPresent / $totalDays) * 100
            : 0;

        return view('StudentDashboard.dashboard', compact(
            'studentAttendance', 'totalPresent', 'totalAbsent', 'totalLeave','unreadNotificationCount','unreadNotifications', 'attendancePercentage'
        ));
    }


}
