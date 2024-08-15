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
        $sections = Section::with('employee','classe')->get();

        return view('section.sectionlist',compact('sections'));
     }
     public function store(Request $request){
        $class = new Section();
        $class->name = $request->name;
        $class->capacity = $request->capacity;
        $class->employee_id = $request->employ;
        $class->classe_id = $request->class;
        $class->note = $request->note;
        $class->save();
        return redirect()->back()->with('message', 'class successfully added!');
     }
     public function del($id){
        $exams = Section::findOrFail($id);
        $exams->delete();
        return redirect()->back()->with('message','class deleted successfully');
     }
     public function edit($id){
        $teacher= Employee::get();
        $class = Classe::get();
        $section = Section::with('employee','classe')->findOrFail($id);
       return view('section.editsection',compact('section','teacher','class'));
     }
     public function update(Request $request,$id){
        $class = Section::findOrFail($id);
        $class->name = $request->name;
        $class->capacity = $request->capacity;
        $class->employee_id = $request->employ;
        $class->classe_id = $request->class;
        $class->note = $request->note;

        $class->save();
        return redirect()->back()->with('message', 'Exam successfully updated!');

     }
}
