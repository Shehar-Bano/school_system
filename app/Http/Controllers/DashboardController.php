<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeSalary;
use App\Models\Expence;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentFee;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Count of students and employees
        $students = Student::count();
        $employee = Employee::count();
        $income = StudentFee::sum('total');
        $expence = Expence::sum('amount');
        $salary = EmployeeSalary::with('employee')->where('status', 'paid')->get();
        $expences = Expence::select('id', 'amount')->get();
        $incomes = StudentFee::select('id', 'total')->get();
        $salaries = $salary->map(function ($salary) {
            return $salary->employee->salary;
        });

        $totalSalary = $salary->sum(function ($salary) {
            return $salary->employee->salary ?? 0;
        });
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

        return view('dashboard', compact('students', 'employee', 'income', 'expence', 'totalSalary', 'salaries', 'expences', 'income', 'employeeAttendance', 'studentAttendance'));
    }
}
