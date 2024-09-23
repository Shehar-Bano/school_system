<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(){
        return view('notification.index');
    }

    public function sendNotification(Request $request)
    {
        $title = $request->input('title');
        $message = $request->input('message');
        $sender = Auth::user()->name;
    
        // Notify students
        $students = Student::all();
        foreach ($students as $student) {
            $student->notify(new AdminNotification($title, $message, $sender));
        }
    
        // Notify employees
        $employees = Employee::all();
        foreach ($employees as $employee) {
            $employee->notify(new AdminNotification($title, $message, $sender));
        }
    
        return back()->with('success', 'Notification sent to students and employees.');
    }
}
