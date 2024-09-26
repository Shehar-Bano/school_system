<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Result;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\StudentFee;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
      
        $classes = Classe::get();
        $sections = Section::get();

        $query = Student::with('class', 'section', 'exam');
        if ($request->has('class') && ! empty($request->input('class'))) {
            $query->where('class_id', $request->input('class'));
        }
        if ($request->has('section') && ! empty($request->input('section'))) {
            $query->where('section_id', $request->input('section'));
        }

        $students = $query->get();

        return view('history.index', compact('students', 'classes', 'sections'));
    }

    public function showHistory($student_id)
    {
        // Fetch student details
        $student = Student::findOrFail($student_id);

        // Fetch student's history
        $attendance = StudentAttendance::where('student_id', $student_id)->get();
        $grades = Result::where('student_id', $student_id)->get();
        $payments = StudentFee::where('student_id', $student_id)->get();

        // Return the admin view with all the data
        return view('history.student-history', compact('student', 'attendance', 'grades', 'payments'));
    }
}
