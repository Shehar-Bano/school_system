<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
     public function index(){
        return view('exam.exam');
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
        return view('exam.examlist',compact('exams'));
     }
     public function del($id){
        $exams = Exam::findOrFail($id);
        $exams->delete();
        return redirect()->back()->with('message','Exam deleted successfully');
     }
     public function edit($id){
        $exams = Exam::findOrFail($id);
       return view('exam.update',compact('exams'));
     }
     public function update(Request $request,$id){
        $exam =Exam::findOrFail($id);
        $exam->name = $request->name;
        $exam->exam_fee=$request->exam_fee;
         $exam->note = $request->note;
        $exam->save();
        return redirect()->back()->with('message', 'Exam successfully added!');

     }
}
