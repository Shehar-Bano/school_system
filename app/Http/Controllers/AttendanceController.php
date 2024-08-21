<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\TeacherAttendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendanceView()
    {
        $employees=Employee::get();
        $attendaces=EmployeeAttendance::with('employee')->get();
        return view('attendance.addEmployee',compact('attendaces','employees'));
    }
    public function attendanceStore(Request $request){
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required',
        ]);

        $date=$request->date;
        $attendaces=$request->attendance;
        $records = [];
        foreach ($attendaces as $employeeId => $status) {
            $records[] = [
                'employee_id' => $employeeId,
                'date' => $date,
                'attendance' => $status,
            ];
        }

        EmployeeAttendance::insert( $records);
        return redirect()->back()->with('message','Attendance added successfully!');


    }
}
