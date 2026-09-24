<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeSalary;
use App\Models\Exam;
use App\Models\Expence;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentFee;
use App\Models\Subject;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Core Statistics
        $students = Student::count();
        $employee = Employee::count();
        $classes_count = Classe::count();
        $sections_count = Section::count();
        $subjects_count = Subject::count();
        $exams_count = Exam::count();

        // Financial Overview
        $income = StudentFee::sum('total') ?? 0;
        $expence = Expence::sum('amount') ?? 0;
        $salary = EmployeeSalary::with('employee')->where('status', 'paid')->get();
        $totalSalary = $salary->sum(function ($item) {
            return $item->employee->salary ?? 0;
        });

        // Attendance Overview
        $employeeAttendance = EmployeeAttendance::selectRaw('
            COUNT(CASE WHEN status = "present" THEN 1 END) as `present`,
            COUNT(CASE WHEN status = "absent" THEN 1 END) as `absent`,
            COUNT(CASE WHEN status = "leave" THEN 1 END) as `leave`,
            COUNT(CASE WHEN status = "late" THEN 1 END) as `late`,
            COUNT(CASE WHEN status = "excused_late" THEN 1 END) as `excused_late`
        ')
            ->groupBy('employee_id')
            ->get();

        $studentAttendance = StudentAttendance::selectRaw('
            COUNT(CASE WHEN status = "present" THEN 1 END) as `present`,
            COUNT(CASE WHEN status = "absent" THEN 1 END) as `absent`,
            COUNT(CASE WHEN status = "leave" THEN 1 END) as `leave`,
            COUNT(CASE WHEN status = "late" THEN 1 END) as `late`,
            COUNT(CASE WHEN status = "excused_late" THEN 1 END) as `excused_late`
        ')
            ->groupBy('student_id')
            ->get();

        // Recent Activity Data
        $recentStudents = Student::with(['class', 'section'])->latest()->take(5)->get();
        $recentExams = Exam::latest()->take(4)->get();

        return view('dashboard', compact(
            'students',
            'employee',
            'classes_count',
            'sections_count',
            'subjects_count',
            'exams_count',
            'income',
            'expence',
            'totalSalary',
            'employeeAttendance',
            'studentAttendance',
            'recentStudents',
            'recentExams'
        ));
    }
}
