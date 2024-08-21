<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\classe;
use App\Models\DateSheet;
use App\Models\ExamSchedule;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamScheduleController extends Controller
{
    public function index()
    {
        $sections= Section::get();
        $classes = Classe::get();
        $exams = Exam::get();
        return view('exam.exam-schedule', compact('classes','sections','exams'));
    }
    public function list(){
        $exams = ExamSchedule::with('section','class','exam')->get();
        return view('exam.schedulelist',compact('exams'));
     }
     public function store(Request $request)
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
    public function del($id){
        $exam = ExamSchedule::findOrFail($id);
        $exam->delete();
        return redirect()->back()->with('message', 'Exam Schedule deleted successfully!');

    }
    public function edit($id){
        $schedule = ExamSchedule::find($id);
        $sections= Section::get();
        $classes = Classe::get();

        $exams = Exam::get();
        return view('exam.edit-schedule', compact('classes','sections','exams','schedule'));
    }
    public function updateschedule(Request $request, $id)
    {
        $examSchedule = ExamSchedule::findOrFail($id);
        $examSchedule->class_id =$request->class_id;
        $examSchedule->exam_id =$request->exam_id;
        $examSchedule->section_id = $request->section_id;


        $examSchedule->start_date = $request->start_date;
        $examSchedule->end_date = $request->end_date;
        $examSchedule->save();

        // Redirect back with a success message
        return redirect()->back()->with('message', 'Exam Schedule updated successfully!');
    }
    public function datesheetview($id){
        $exam = ExamSchedule::find($id);
        $subjects = Subject::get();
        return view('exam.date_sheet',compact('exam','subjects'));

    }
    public function datesheet(Request $request, $id)
    {
        $exam = ExamSchedule::find($id);
        $validatedData = $request->validate([
            'subject_id.*' => 'required|exists:subjects,id',
            'date.*' => 'required|date',
            'start_time.*' => 'required|date_format:H:i',
            'end_time.*' => 'required|date_format:H:i|after:start_time.*',
        ]);

        foreach ($validatedData['subject_id'] as $index => $subjectId) {
            $dateSheet = new DateSheet();
            $dateSheet->exam_schedule_id = $exam->id;
            $dateSheet->subject_id = $subjectId;
            $dateSheet->date = $validatedData['date'][$index];
            $dateSheet->start_time = $validatedData['start_time'][$index];
            $dateSheet->end_time = $validatedData['end_time'][$index];
            $dateSheet->save();
        }

        return redirect()->back()->with('success', 'Exam schedule added successfully!');
        }


    public function datesheetlist($id){
        $exams = ExamSchedule::find($id);


        $datesheets = DateSheet::with('subject')->get();
        return view('exam.datesheetlist',compact('exams','datesheets'));
    }
    public function datedel($id){

        $datesheet = DateSheet::find($id);
        $datesheet->delete();
        return redirect()->back()->with('message','deleted successfully');
    }
    public function dateedit($id){


    $exam = DateSheet::where('id', $id)->first();
    $subjects = Subject::all(); // Assuming you have a Subject model to get all subjects
     return view('exam.date_edit',compact('exam','subjects'));

    }
    public function dateupdateschedule(Request $request, $id) {
        $exam = DateSheet::where('id', $id)->first();
        $exam->date = $request->date;
        $exam->start_time = $request->start_time;
        $exam->end_time = $request->end_time;
        $exam->save();
    return redirect()->back()->with('success', 'Exam schedule updated successfully!');
}


 }
