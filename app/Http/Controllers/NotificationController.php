<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Student;
use App\Notifications\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notification.index');
    }

    public function sendNotification(Request $request)
    {
        $title = $request->input('title');
        $message = $request->input('message');
        $sender = Auth::user()->name;
        $recipient = $request->input('recipient');

        // Notify based on recipient selection
        if ($recipient === 'student' || $recipient === 'both') {
            // Notify students
            $students = Student::all();
            foreach ($students as $student) {
                $student->notify(new AdminNotification($title, $message, $sender));
            }
        }

        if ($recipient === 'employee' || $recipient === 'both') {
            // Notify employees
            $employees = Employee::all();
            foreach ($employees as $employee) {
                $employee->notify(new AdminNotification($title, $message, $sender));
            }
        }

        return back()->with('success', 'Notification sent successfully.');
    }
}
