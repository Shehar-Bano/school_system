<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\Student;
use App\Models\TeacherAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //////////Employees/////////////
    public function employeeAttendanceView(Request $request){
        $query =  Employee::query();
        $designations =Designation::get();

        if($request->has('designation')){
            $query->where('designation_id', 'like', '%' . $request->input('designation') . '%');
        }
       
    if ($request->has('id')) {
        $query->where('id', 'like', '%' . $request->input('id') . '%');
    }

    $employees=$query->paginate(3);
       
       
        return view('attendance.viewEmployee',compact('employees','designations'));
    }


    ///////////////////////////////////////////////////////////////////////////
    public function showEmployeeAttendace($id){
        $employee=Employee::find($id);
        $attendanceRecords = EmployeeAttendance::where('employee_id', $employee->id)->get();
    // Initialize an array to hold attendance data
    $attendanceData = [];
    $late=0;
    $exculate=0;
    $present=0;
    $absent=0;
    $leave=0;
    // Loop through each record and populate the array
    foreach ($attendanceRecords as $record) {
        $date = Carbon::parse($record->date);
        $month = $date->format('M');
        $day = $date->day;
        $dayOfWeek = $date->format('D');
      
        // Store the attendance status in the array
        if ($record->status == 'present') {
           ++$present;
            $attendanceData[$month][$day] = 'P';
            } elseif ($record->status == 'absent') {
                ++$absent;
                $attendanceData[$month][$day] = 'A';
                } elseif($record->status == 'leave') {
                   ++$leave;
                    $attendanceData[$month][$day] = 'LV';
                    } elseif($record->status == 'late') {
                        ++$late;
                        $attendanceData[$month][$day] = 'L';
                        } elseif($record->status == 'excused_late') {
                            ++$exculate;
                            $attendanceData[$month][$day] = 'EL';
                            }
                           
    }   
  
    $totalLeave = $leave;    
    $totalPresent = $present;  
    $totalLateExcuse = $exculate; 
    $totalLate = $late;     
    $totalAbsent = $absent;  

        return view('attendance.employeeAttendance',compact('employee', 'attendanceData',
        'totalLeave', 'totalPresent', 'totalLateExcuse', 'totalLate', 'totalAbsent'));
    }


////////////////////////////////////////////////////////////////////////////////
    public function addAttendanceView()
    {
        $employees=Employee::get();
        // $attendaces=EmployeeAttendance::with('employee')->get();
        return view('attendance.addEmployee',compact('employees'));
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
                'status' => $status,
            ];
        }

        EmployeeAttendance::insert( $records);
        return redirect()->back()->with('message','Attendance added successfully!');


    }

    //////////////Students///////////////////////////////
    public function studentAttendanceView()
    {
        $students=Student::paginate(2);
        return view('attendance.viewStudent',compact('students'));
    }
    public function addStudentAttendanceView(){
        $students=Student::get();
        return view('attendance.addStudent',compact('students'));

    }

}
