<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\Finance_recode;
use App\Models\TimeTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->guard('employee')->user();
        if (! $user) {
            return redirect()->route('employee.login')->with('error', 'You need to log in first.');
        }
        $employee = Employee::where('id', $user->id)->where('designation_id', '1')
            ->with('designation')
            ->first();
        if (! $employee) {
            return redirect()->route('student.login')->with('error', 'Teacher record not found.');
        }

        // {{$students}}
        return view('employeeDashboard.profile', compact('employee'));

    }

    public function attendance(Request $request)
    {
        $user = auth()->guard('employee')->user();

        if (! $user) {
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
                $present++;
                $attendanceData[$dayOfWeek][$day] = 'P';
            } elseif ($record->status == 'absent') {
                $absent++;
                $attendanceData[$dayOfWeek][$day] = 'A';
            } elseif ($record->status == 'leave') {
                $leave++;
                $attendanceData[$dayOfWeek][$day] = 'LV';
            } elseif ($record->status == 'late') {
                $late++;
                $attendanceData[$dayOfWeek][$day] = 'L';
            } elseif ($record->status == 'excused_late') {
                $excusedLate++;
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

    public function timeTable()
    {
        $user = auth()->guard('employee')->user();
        if (! $user) {
            return redirect()->route('employee.login')->with('error', 'You need to log in first.');
        }
        $timetable = TimeTable::where('teacher_id', $user->id)->get();

        return view('employeeDashboard.time_table', compact('timetable'));
    }

    public function incentives(Request $request)
    {
        // Get the authenticated employee
        $user = auth()->guard('employee')->user();
        if (! $user) {
            return redirect()->route('employee.login')->with('error', 'You need to log in first.');
        }

        $employees = Employee::get(); // This can be used for displaying employee details if needed
        $query = Finance_recode::with('employee')
            ->where('employee_id', $user->id); // Filter records for the logged-in employee

        if ($request->has('transaction_type')) {
            $query->where('transaction_type', 'like', '%'.$request->input('transaction_type').'%');
        }

        if ($request->has('start_date') && $request->has('end_date') &&
            $request->input('start_date') != '' && $request->input('end_date') != '') {
            $query->whereBetween('transaction_date', [$request->input('start_date'), $request->input('end_date')]);
        }

        // Fetch the records and ensure transaction_date is a Carbon instance
        $recodes = $query->get()->each(function ($record) {
            $record->transaction_date = \Carbon\Carbon::parse($record->transaction_date);
        });

        // Calculate incentives based on transaction type
        $incentives = $recodes->groupBy('transaction_type')->map(function ($records, $transactionType) {
            return $records->sum('amount');
        });

        return view('employeeDashboard.incentives', compact('recodes', 'employees', 'incentives'));
    }

    public function notificationsView()
    {
        // Get the logged-in employee
        $employee = Auth::guard('employee')->user();

        // Fetch all notifications for the logged-in employee
        $notifications = $employee->notifications;

        // Count the unread notifications
        $unreadNotificationCount = $employee->unreadNotifications->count();

        // Pass the data to the view
        return view('employeeDashboard.notifications.index', compact('notifications', 'unreadNotificationCount'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->guard('employee')->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Redirect to the notifications page or wherever you want
        return redirect()->back()->with('success', 'Notification marked as read.');
    }
}
