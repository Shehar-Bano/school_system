<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;

class EmployeeDashboardController extends Controller
{
    public function index(){
        $teacherId = auth()->guard('employee')->user()->id;
        $currentYear = now()->year;
        $teacherAttendance = EmployeeAttendance::where('employee_id', $teacherId)
            ->whereYear('date', $currentYear)
            ->get();
         $totalDays = $teacherAttendance->count();
        $totalPresent=$teacherAttendance->where('status', 'present')->count();
        $totalAbsent = $teacherAttendance->where('status', 'absent')->count();
        $totalLeave = $teacherAttendance->where('status', 'leave')->count();
        $attendancePercentage = $totalDays > 0
            ? ($totalPresent / $totalDays) * 100
            : 0;
        return view('employeeDashboard.dashboard', compact(
            'teacherAttendance', 'totalPresent', 'totalAbsent', 'totalLeave', 'attendancePercentage'
        ));
    }
}
