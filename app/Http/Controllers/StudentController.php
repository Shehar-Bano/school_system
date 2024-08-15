<?php

namespace App\Http\Controllers;
use App\Models\classe;
use App\Models\Student;
use App\Models\Employee;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $teacher= Employee::get();
        $class = Classe::get();
        return view('student.student', compact('students','class','teacher'));
    }
    public function list(){
        $sections = Student::with('employee','classe')->get();
        return view('section.studentlist',compact('sections'));
     }
 public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guardian' => 'required|string',
            'admissiondate' => 'required|date',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'class' => 'required|exists:classes,id',
            'section' => 'required|exists:sections,id',
            'group' => 'required|string',
            // Add other validations as needed
        ]);

        // Handle file upload if there's an image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('students', 'public');
        } else {
            $imagePath = null;
        }

        // Create the student
        $student = new Student([
            'name' => $request->input('name'),
            'guardian' => $request->input('guardian'),
            'admissiondate' => $request->input('admissiondate'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'religion' => $request->input('religion'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'class_id' => $request->input('class'),
            'section_id' => $request->input('section'),
            'group' => $request->input('group'),
            'registration' => $request->input('registration'),
            'username' => $request->input('username'),
            'password' => bcrypt($request->input('password')),
            'image' => $imagePath,
            'note' => $request->input('note'),
        ]);

        // Save the student
        $student->save();

        // Redirect with success message
        return redirect()->route('students.create')->with('message', 'Student added successfully!');

    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', compact('student'));
    }
}
