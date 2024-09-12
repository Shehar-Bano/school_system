<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\TimeTable;
use Illuminate\Http\Request;

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
        ->first();
        dd($timetable);
        return view('StudentDashboard.Profile.timetable', compact('timetable'));
    }

}
