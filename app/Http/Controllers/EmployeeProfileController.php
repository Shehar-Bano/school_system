<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeProfileController extends Controller
{
    public function profile(){
        $user = auth()->guard('employee')->user();
        if (!$user) {
            return redirect()->route('employee.login')->with('error', 'You need to log in first.');
        }
        $employee = Employee::where('id', $user->id)->where('designation_id','1')
            ->with('designation')
            ->first();
        if (!$employee) {
            return redirect()->route('student.login')->with('error', 'Teacher record not found.');
        }
        // {{$students}}
        return view('employeeDashboard.profile', compact('employee'));
    
    }
    public function attendance(Request $request)
    {
        $user = auth()->guard('employee')->user();
        
        if (!$user) {
            return redirect()->route('employee.login')->with('error', 'You need to log in first.');
        }
    
        // Fetch employee details
        $employee = Employee::find($user->id);
    
        // Get the selected month and year from the request, or default to the current month and year
        $selectedMonth = $request->get('month', Carbon::now()->format('m'));
        $selectedYear = $request->get('year', Carbon::now()->format('Y'));
    
        // Retrieve attendance records for the selected month and year
        $attendanceRecords = EmployeeAttendance::where('employee_id', $employee->id)
            ->whereMonth('date', $selectedMonth)
            ->whereYear('date', $selectedYear)
            ->get();
    
        // Initialize an array to hold attendance data
        $attendanceData = [];
        $late = 0;
        $excusedLate = 0;
        $present = 0;
        $absent = 0;
        $leave = 0;
    
        // Loop through each record and populate the array
        foreach ($attendanceRecords as $record) {
            $date = Carbon::parse($record->date);
            $dayOfWeek = $date->format('D');
            $day = $date->day;
    
            // Store the attendance status in the array
            if ($record->status == 'present') {
                ++$present;
                $attendanceData[$dayOfWeek][$day] = 'P';
            } elseif ($record->status == 'absent') {
                ++$absent;
                $attendanceData[$dayOfWeek][$day] = 'A';
            } elseif ($record->status == 'leave') {
                ++$leave;
                $attendanceData[$dayOfWeek][$day] = 'LV';
            } elseif ($record->status == 'late') {
                ++$late;
                $attendanceData[$dayOfWeek][$day] = 'L';
            } elseif ($record->status == 'excused_late') {
                ++$excusedLate;
                $attendanceData[$dayOfWeek][$day] = 'EL';
            }
        }
    
        // Define months for the dropdown
        $months = [
            '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
            '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
            '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December',
        ];
    
        $totalLeave = $leave;
        $totalPresent = $present;
        $totalLateExcuse = $excusedLate;
        $totalLate = $late;
        $totalAbsent = $absent;
    
        return view('employeeDashboard.attendence', compact(
            'employee', 'attendanceData', 'totalLeave', 'totalPresent', 'totalLateExcuse',
            'totalLate', 'totalAbsent', 'selectedMonth', 'selectedYear', 'months'
        ));
    }
    
}
