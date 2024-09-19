<?php

namespace App\Http\Controllers\Student;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Student;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use App\Models\StudentAttendance;
use App\Http\Controllers\Controller;
use App\Models\ExamSchedule;
use App\Models\StudentFee;
use App\Models\StudentTransaction;

class StudentProfileController extends Controller
{
    public function index() {
        $user = auth()->guard('student')->user();
        if (!$user) {
            return redirect()->route('student.login')->with('error', 'You need to log in first.');
        }
        $student = Student::where('id', $user->id)
            ->with('class', 'section')
            ->first();
        if (!$student) {
            return redirect()->route('student.login')->with('error', 'Student record not found.');
        }
        // {{$students}}
        return view('StudentDashboard.Profile.index', compact('student'));
    }
    public function timeTable(){
        $user = auth()->guard('student')->user();
        if (!$user) {
            return redirect()->route('student.login')->with('error', 'You need to log in first.');
        }
        $timetable = TimeTable::where('class_id', $user->class_id)
        ->where('section_id',$user->section_id)
        ->get();
        return view('StudentDashboard.Profile.timetable', compact('timetable'));
    }
    public function attendence(Request $request)
{
    $user = auth()->guard('student')->user();
    if (!$user) {
        return redirect()->route('student.login')->with('error', 'You need to log in first.');
    }

    $selectedMonth = $request->get('month', Carbon::now()->format('m'));
    $selectedYear = $request->get('year', Carbon::now()->format('Y'));
    $attendence = StudentAttendance::where('class_id', $user->class_id)
        ->where('section_id', $user->section_id)
        ->where('student_id', $user->id)
        ->whereMonth('date', $selectedMonth)
        ->whereYear('date', $selectedYear)
        ->get();

    $attendanceData = [];
    $late = 0;
    $exculated = 0;
    $present = 0;
    $absent = 0;
    $leave = 0;

    foreach ($attendence as $record) {
        $date = Carbon::parse($record->date);
        $day = $date->day; // Get day of the month (1-31)

        // Check the record status and count occurrences
        if ($record->status == 'present') {
            ++$present;
            $attendanceData[$day] = 'present'; // Store status by day number
        } elseif ($record->status == 'absent') {
            ++$absent;
            $attendanceData[$day] = 'absent';
        } elseif ($record->status == 'leave') {
            ++$leave;
            $attendanceData[$day] = 'leave';
        } elseif ($record->status == 'late') {
            ++$late;
            $attendanceData[$day] = 'late';
        } elseif ($record->status == 'excused_late') {
            ++$exculated;
            $attendanceData[$day] = 'excused late';
        }
    }

    $months = [
        '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
        '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
        '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December',
    ];

    $totalLeave = $leave;
    $totalPresent = $present;
    $totalLateExcuse = $exculated;
    $totalLate = $late;
    $totalAbsent = $absent;

    return view('StudentDashboard.Profile.attendence', compact(
        'attendanceData',
        'totalLeave', 'totalPresent', 'totalLateExcuse',
        'totalLate', 'totalAbsent', 'selectedMonth',
        'selectedYear', 'months', 'user'
    ));
}

    public function result(Request $request){
        $user = auth()->guard('student')->user();
        if (!$user) {
            return redirect()->route('student.login')->with('error', 'You need to log in first.');
        }
        $exams = Exam::get();
        $query = Result::where('student_id', $user->id)
        ->where('class_id', $user->class_id)
        ->where('section_id', $user->section_id);

        if ($request->has('exam') && !empty($request->input('exam'))) {
            $query->where('exam_id', $request->input('exam'));
        }
        $result = $query->get();

        return view('StudentDashboard.Profile.result', compact('result', 'user','exams'));
    }
    public function fee()
    {
        $user = auth()->guard('student')->user();
        if (!$user) {
            return redirect()->route('student.login')->with('error', 'You need to log in first.');
        }

        // Fetch student fee, fines, and other related transactions
        $fee = StudentFee::where('student_id', $user->id)->first();
        $fines = StudentTransaction::where('student_id', $user->id)
            ->where('transaction_type', 'fine')
            ->get();

        $funds = StudentTransaction::where('student_id', $user->id)
            ->where('transaction_type', 'fund')
            ->get();

        // Static fee types
        $feeTypes = [
            'Admission' => 100,
            'Other Activity' => 300,
            'School Bus' => 50,
            'Lunch' => 50,
            'Diary' => 50,
        ];

        // Fees array to store all student fees (static + fines)
        $studentFees = [];

        foreach ($feeTypes as $feeType => $amount) {
            $studentFees[] = [
                'fee_type' => $feeType,
                'amount' => $amount,
                'paid' => 0, // Assuming no payment for now
            ];
        }

        // Add tuition fee (assumed to be dynamic)
        $studentFees[] = [
            'fee_type' => 'Tuition Fee',
            'amount' => $user->tution_fee ?? 0, // default to 0 if not set
            'paid' => 0,
        ];

        // Add fines
        foreach ($fines as $fine) {
            $studentFees[] = [
                'fee_type' => 'Fine',
                'amount' => $fine->amount,
                'paid' => $fine->paid_amount,
            ];
        }

        // Calculate totals
        $totalAmount = array_sum(array_column($studentFees, 'amount'));
        $scholarship = $funds->sum('amount');
        $totalDue = $totalAmount - $scholarship;

        return view('StudentDashboard.Profile.fee', compact('studentFees', 'user', 'totalAmount', 'scholarship', 'totalDue'));
    }


}
