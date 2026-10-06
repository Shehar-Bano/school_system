<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\ClassesSubject;
use App\Models\Employee;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index()
    {
        if (auth()->check() && !auth()->user()->can('academic.class.create')) {
            abort(403, 'Unauthorized: You do not have permission to create classes.');
        }

        $subjects = Subject::get();

        $teacher = Employee::get();

        return view('class.class', compact('subjects'));
    }

    public function list()
    {
        if (auth()->check() && !auth()->user()->can('academic.class.view')) {
            abort(403, 'Unauthorized: You do not have permission to view classes.');
        }

        $subjects = ClassesSubject::with('subject')->get();
        $classes = classe::with('employee', 'classsubject')->get();

        return view('class.classlist', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        if (auth()->check() && !auth()->user()->can('academic.class.create')) {
            abort(403, 'Unauthorized: You do not have permission to create classes.');
        }

        // Create a new class instance
        $class = new Classe;
        $class->name = $request->name;
        $class->tution_fee = $request->tution_fee;
        $class->note = $request->note;
        $class->save();

        // Loop through each selected subject and save it with the class
        if ($request->has('subject_id') && is_array($request->subject_id)) {
            foreach ($request->subject_id as $subjectId) {
                $subject = new ClassesSubject;
                $subject->class_id = $class->id;
                $subject->subject_id = $subjectId;
                $subject->save();
            }
        }

        return redirect()->back()->with('message', 'Class successfully added!');
    }

    public function del($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.class.delete')) {
            abort(403, 'Unauthorized: You do not have permission to delete classes.');
        }

        $exams = Classe::findOrFail($id);
        $exams->delete();

        return redirect()->back()->with('message', 'class deleted successfully');
    }

    public function edit($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.class.edit')) {
            abort(403, 'Unauthorized: You do not have permission to edit classes.');
        }

        $teacher = Employee::get();
        $classes = Classe::with('employee')->findOrFail($id);

        return view('class.editclass', compact('classes', 'teacher'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->check() && !auth()->user()->can('academic.class.edit')) {
            abort(403, 'Unauthorized: You do not have permission to update classes.');
        }

        $class = Classe::findOrFail($id);
        $class->name = $request->name;
        $class->tution_fee = $request->tution_fee;
        $class->note = $request->note;
        $class->save();

        return redirect()->back()->with('message', 'Exam successfully updated!');

    }
}
