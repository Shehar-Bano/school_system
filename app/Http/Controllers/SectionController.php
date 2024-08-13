<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Section;
use App\Models\Employee;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $teacher= Employee::get();
        $class = Classe::get();
        return view('section.section', compact('teacher','class'));
    }
    public function list(){
        $sections = Section::with('employee','class')->get();

        return view('class.classlist',compact('sections'));
     }
     public function store(Request $request){
        $class = new Classe();
        $class->name = $request->name;
        $class->employee_id = $request->employ;
        $class->note = $request->note;
        $class->save();
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
        $class->employee_id = $request->employ;
        $class->note = $request->note;

        $class->save();
        return redirect()->back()->with('message', 'Exam successfully updated!');

     }
}
