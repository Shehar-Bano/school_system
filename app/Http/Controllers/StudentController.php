<?php

namespace App\Http\Controllers;
use App\Models\classe;
use App\Models\Section;
use App\Models\Student;
use App\Models\Employee;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $sections= Section::get();
        $classes = Classe::get();
        return view('student.students', compact('classes','sections'));
    }
    public function list(){
        $students = Student::with('employee','classe')->get();
        return view('student.studentlist',compact('students'));
     }
     public function store(Request $request)
     {
        // dd($request);
        //  Validate the request data
         $request->validate([
             'name' => 'required|string|max:255',
             'gurdian' => 'required|string|max:255',
             'admissiondate' => 'required|date',
             'dob' => 'required|date',
             'gender' => 'required|string|in:male,female,other',
             'religion' => 'nullable|string|max:255',
             'email' => 'nullable|email|max:255',
             'phone' => 'nullable|string|max:255',
             'address' => 'nullable|string|max:255',
             'class' => 'required',
             'section' => 'required',
             'group' => 'required|string|in:arts,science,commerce',
             'registration' => 'nullable|string|max:255',
             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',

         ]);

         // Handle file upload if there's an image
         $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('students', 'public')
            : null;

         // Create the student
         $student = Student::create([
             'name' => $request->input('name'),
             'gurdian' => $request->input('gurdian'),
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
             'image' => $imagePath,


         ]);


         // Redirect with success message
         return redirect()->back()->with('message', 'Student added successfully!');
     }


    public function del($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->back()->with('message','deleted successfully');
    }
}
