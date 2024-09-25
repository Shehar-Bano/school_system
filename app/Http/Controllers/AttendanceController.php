<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;


class AttendanceController extends Controller
{
    //////////Employees/////////////
    public function employeeAttendanceView(Request $request)
    {
        $query = Employee::query();
        $designations = Designation::get();

        if ($request->has('designation')) {
            $query->where('designation_id', 'like', '%' . $request->input('designation') . '%');
        }

        if ($request->has('id')) {
            $query->where('id', 'like', '%' . $request->input('id') . '%');
        }

        $employees = $query->paginate(3);


        return view('attendance.viewEmployee', compact('employees', 'designations'));
    }


    ///////////////////////////////////////////////////////////////////////////
    public function showEmployeeAttendance(Request $request, $id)
    {
        $employee = Employee::find($id);

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
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];

        $totalLeave = $leave;
        $totalPresent = $present;
        $totalLateExcuse = $excusedLate;
        $totalLate = $late;
        $totalAbsent = $absent;

        return view('attendance.employeeAttendance', compact(
            'employee',
            'attendanceData',
            'totalLeave',
            'totalPresent',
            'totalLateExcuse',
            'totalLate',
            'totalAbsent',
            'selectedMonth',
            'selectedYear',
            'months'
        ));
    }



    ////////////////////////////////////////////////////////////////////////////////
    public function addAttendanceView()
    {
        $employees = Employee::get();
        
        return view('attendance.addEmployee', compact('employees'));
    }
    ////////////////////////////////////////////////////////////////////////
    public function employeeAttendanceStore(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required',
        ]);

        $date = $request->date;
        $attendaces = $request->attendance;
        $records = [];
        foreach ($attendaces as $employeeId => $status) {
            $records[] = [
                'employee_id' => $employeeId,
                'date' => $date,
                'status' => $status,
            ];
        }

        EmployeeAttendance::insert($records);
        return redirect()->back()->with('message', 'Attendance added successfully!');


    }

    //////////////Students///////////////////////////////
    public function attendanceClass(Request $request)
    {
        $classes = classe::with('section')->get();
        $sections = Section::get();
        $query = Student::query();
        if ($request->has('class')) {
            $query->where('class_id', $request->class);
        }
        if ($request->has('section')) {
            $query->where('section_id', $request->section);
        }
        $students = $query->paginate(2);

        return view('attendance.attendanceClass', compact('classes', 'sections', 'students'));
    }
    public function studentAttendanceView(Request $request)
    {

        $classes = classe::with('section')->get();
        $sections = Section::with('classe', 'employee')->get();
        $query = Student::query();
        if ($request->has('class')) {

            $query->where('class_id', 'like', '%' . $request->input('class') . '%');
        }
        if ($request->has('section')) {
            $query->where('section_id', 'like', '%' . $request->input('section') . '%');
        }
        $students = $query->paginate(4);
        return view('attendance.viewStudent', compact('students', 'classes', 'sections'));
    }
    public function addStudentAttendanceView(Request $request)
    {
        $classId = $request->class;
        $sectionId = $request->section;

        $students = Student::where('class_id', $classId)->where('section_id', $sectionId)->get();

        if ($students->isEmpty()) {
            dd($students);
            return redirect()->back()->with('error', 'No student found in this class and section');
        }
        $classes = classe::get();
        $sections = Section::get();
        return view('attendance.addStudent', compact('students', 'classes', 'sections'));

    }
    public function studentAttendanceStore(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required',
        ]);
        $date = $request->date;
        $attendaces = $request->attendance;
        $records = [];
        foreach ($attendaces as $studentId => $status) {
            $existingAttendance = StudentAttendance::where('student_id', $studentId)
                ->where('date', $date)
                ->first();

            if ($existingAttendance) {
                // Remove existing attendance record
                $existingAttendance->delete();
            }

            $records[] = [
                'student_id' => $studentId,
                'date' => $date,
                'status' => $status,
                'class_id' => $request->class,
                'section_id' => $request->section
            ];
        }
        StudentAttendance::insert($records);
        return redirect()->back()->with('message', 'Student Attendance added successfully!');
    }
    public function studentAttendanceViewDetails($id)
    {
        $student = Student::find($id);
        $attendances = StudentAttendance::where('student_id', $id)->get();
        return view('attendance.viewStudentDetails', compact('student', 'attendances'));
    }

    public function classAttendanceView(Request $request)
    {
        $classId = $request->class_id;
        $sectionId = $request->section_id;
        return redirect()->back()->with(compact('classId', 'sectionId'));

    }

    //////to show attendance
    public function showStudentAttendance(Request $request, $id)
    {
        $student = Student::with('class', 'section')->find($id);

        // Get the selected month and year from the request, or default to the current month and year
        $selectedMonth = $request->get('month', Carbon::now()->format('m'));
        $selectedYear = $request->get('year', Carbon::now()->format('Y'));

        // Retrieve attendance records for the selected month and year
        $attendanceRecords = StudentAttendance::where('student_id', $student->id)
            ->whereMonth('date', $selectedMonth)
            ->whereYear('date', $selectedYear)
            ->get();

        $attendanceData = [];
        $late = 0;
        $exculated = 0;
        $present = 0;
        $absent = 0;
        $leave = 0;

        foreach ($attendanceRecords as $record) {
            $date = Carbon::parse($record->date);
            $dayOfWeek = $date->format('D');
            $day = $date->day;

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
                ++$exculated;
                $attendanceData[$dayOfWeek][$day] = 'EL';
            }
        }



        $months = [
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];

        $totalLeave = $leave;
        $totalPresent = $present;
        $totalLateExcuse = $exculated;
        $totalLate = $late;
        $totalAbsent = $absent;

        return view('attendance.studentAttendance', compact(
            'student',
            'attendanceData',
            'totalLeave',
            'totalPresent',
            'totalLateExcuse',
            'totalLate',
            'totalAbsent',
            'selectedMonth',
            'selectedYear',
            'months'
        ));
    }





}
