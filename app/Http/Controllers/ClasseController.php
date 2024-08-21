<?php

namespace App\Http\Controllers;

use App\Models\Class_Subject;
use App\Models\classe;
use App\Models\ClassesSubject;
use App\Models\Employee;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index(){
      $subjects=Subject::get();
      
        $teacher= Employee::get();
        return view('class.class', compact('subjects'));
    }
    public function list(){
        $subjects=ClassesSubject::with('subject')->get();
        $classes = classe::with('employee','classsubject')->get();

        return view('class.classlist',compact('classes','subjects'));
     }
     public function store(Request $request)
     {
         // Create a new class instance
         $class = new Classe();
         $class->name = $request->name;
         $class->note = $request->note;
         $class->save();
     
         // Loop through each selected subject and save it with the class
         foreach ($request->subject_id as $subjectId) {
             $subject = new ClassesSubject();
             $subject->class_id = $class->id;
             $subject->subject_id = $subjectId;
             $subject->save();
         }
     
         return redirect()->back()->with('message', 'Class successfully added!');
     }
     
     public function del($id){
        $exams = Classe::findOrFail($id);
        $exams->delete();
        return redirect()->back()->with('message','class deleted successfully');
     }
     public function edit($id){
        $teacher= Employee::get();
        $classes = Classe::with('employee')->findOrFail($id);
       return view('class.editclass',compact('classes','teacher'));
     }
     public function update(Request $request,$id){
        $class = Classe::findOrFail($id);
        $class->name = $request->name;
        $class->note = $request->note;
        $class->save();

        return redirect()->back()->with('message', 'Exam successfully updated!');

     }
}
