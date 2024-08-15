<?php

namespace App\Http\Controllers;

use App\Models\Class_Subject;
use App\Models\classe;
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
        $classes = classe::with('employee')->get();

        return view('class.classlist',compact('classes'));
     }
     public function store(Request $request){
        $class = new Classe();
        $class->name = $request->name;
        $class->note = $request->note;
        $class->save();
        $subejcts=new Class_Subject();
        
        return redirect()->back()->with('message', 'class successfully added!');
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
