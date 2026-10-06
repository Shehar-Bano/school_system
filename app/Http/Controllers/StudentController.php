<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $sections = Section::all();
        $classes = Classe::get();
        $roles = Role::where('guard_name', 'student')->get();

        return view('student.students', compact('classes', 'sections', 'roles'));
    }

    public function list()
    {
        $students = Student::with('employee', 'class', 'roles')->get();

        return view('student.studentlist', compact('students'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => 'required|string|unique:students,username',
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Check if the username already exists
        if (Student::where('username', $request->input('username'))->exists()) {
            Alert::error('Username already exists', 'Please choose another username');

            return redirect()->back()->withInput(); // Redirect back with form data
        }

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('students', 'public')
            : null;

        // Password hashing: use provided password or fallback to registration or default
        $rawPassword = $request->filled('password') 
            ? $request->input('password') 
            : ($request->input('registration') ?: '123456');

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
            'tution_fee' => $request->input('tution_fee'),
            'fee_concession' => $request->input('fee_concession'),
            'image' => $imagePath,
            'username' => $request->input('username'),
            'password' => Hash::make($rawPassword),
        ]);

        // Assign role to student
        if ($request->filled('role')) {
            $role = Role::where('name', $request->role)->where('guard_name', 'student')->first();
            if ($role) {
                $student->syncRoles([$role]);
            }
        } else {
            $defaultRole = Role::where('name', 'student')->where('guard_name', 'student')->first();
            if ($defaultRole) {
                $student->syncRoles([$defaultRole]);
            }
        }

        // Redirect with success message
        return redirect()->back()->with('message', 'Student registered successfully with portal access!');
    }

    public function del($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->back()->with('message', 'deleted successfully');
    }

    public function edit($id)
    {
        $sections = Section::get();
        $classes = Classe::get();
        $roles = Role::where('guard_name', 'student')->get();
        $student = Student::with('roles')->findOrFail($id);

        return view('student.editstudent', compact('student', 'classes', 'sections', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data and ignore the current student ID
        $request->validate([
            'username' => 'required|string|unique:students,username,'.$id,
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'nullable|string|max:100',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $student = Student::findOrFail($id);
        if ($request->hasFile('image')) {
            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }
            $imagePath = $request->file('image')->store('students', 'public');
        } else {
            $imagePath = $student->image;
        }

        // Prepare student data
        $updateData = [
            'username' => $request->input('username'),
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
            'tution_fee' => $request->input('tution_fee'),
            'registration' => $request->input('registration'),
            'image' => $imagePath,
        ];

        // Update password only if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->input('password'));
        }

        // Update the student record
        $student->update($updateData);

        // Sync role
        if ($request->filled('role')) {
            $role = Role::where('name', $request->role)->where('guard_name', 'student')->first();
            if ($role) {
                $student->syncRoles([$role]);
            }
        }

        // Redirect with success message
        return redirect()->back()->with('message', 'Student and role updated successfully!');
    }
}
