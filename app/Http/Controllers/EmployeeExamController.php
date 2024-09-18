<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Section;
use Illuminate\Http\Request;

class EmployeeExamController extends Controller
{
    public function index(){
        return view('employeeDashboard.exam.add');
     }
     public function store(Request $request){
        $exam = new Exam();
        $exam->name = $request->name;
        if($request->exam_fee==""){
         $exam->exam_fee = 0;
        }
        else{
         $exam->exam_fee=$request->exam_fee;
        }
       
        $exam->note = $request->note;
        $exam->save();
        return redirect()->back()->with('message', 'Exam successfully added!');
     }
     public function list(){
        $exams = Exam::get();
        return view('employeeDashboard.exam.index',compact('exams'));
     }
     public function delete($id){
        $exams = Exam::findOrFail($id);
        $exams->delete();
        return redirect()->back()->with('message','Exam deleted successfully');
     }
     public function edit($id){
        $exams = Exam::findOrFail($id);
       return view('employeeDashboard.exam.edit',compact('exams'));
     }
     public function update(Request $request,$id){
        $exam =Exam::findOrFail($id);
        $exam->name = $request->name;
        $exam->exam_fee=$request->exam_fee;
         $exam->note = $request->note;
        $exam->save();
        return redirect()->back()->with('message', 'Exam successfully added!');

     }
     /////////////////
    public function sheduleList(Request $request){
        $sections= Section::get();
        $classes = classe::get();
        $exams = Exam::get();
        $query = ExamSchedule::with('section','class','exam');
        if ($request->has('class') && !empty($request->input('class'))) {
            $query->where('class_id', $request->input('class'));
        }
        if ($request->has('section') && !empty($request->input('section'))) {
            $query->where('section_id', $request->input('section'));
        }
        if ($request->has('exam') && !empty($request->input('exam'))) {
            $query->where('exam_id', $request->input('exam'));
        }

        $examschedules = $query->get();

        return view('employeeDashboard.shedules.index',compact('exams','classes','sections','examschedules'));
     }
     public function sheduleAdd(Request $request){
      
        {
            $sections= Section::get();
            $classes = Classe::get();
            $exams = Exam::get();
            return view('employeeDashboard.shedules.add', compact('classes','sections','exams'));
        }
}

public function sheduleStore(Request $request)
{

    // Validate the request data
    $validatedData = $request->validate([
        'class_id' => 'required',
        'exam_id' => 'required',
        'section_id' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
    ]);

    $examSchedule = new ExamSchedule();
    $examSchedule->class_id = $validatedData['class_id'];
    $examSchedule->exam_id = $validatedData['exam_id'];
    $examSchedule->section_id = $validatedData['section_id'];
    $examSchedule->start_date = $validatedData['start_date'];
    $examSchedule->end_date = $validatedData['end_date'];


    $examSchedule->save();

    // Redirect back with success message
    return redirect()->back()->with('message', 'Exam Schedule added successfully!');
}
}
