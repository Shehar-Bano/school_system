<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\classe;
use App\Models\Result;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\DateSheet;
use App\Models\ExamSchedule;
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
    public function list(Request $request){
        $sections= Section::get();
        $classes = Classe::get();
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

        return view('exam.schedulelist',compact('exams','classes','sections','examschedules'));
     }
     public function resultPrint($id){

        $students = Student::with('class', 'section', 'exam')->get();
        $examSchedule =ExamSchedule::find($id);
        $results = Result::where('exam_id', $examSchedule->exam_id)
        ->where('class_id',$examSchedule->class_id)
        ->with(['subject', 'student','exam'])
        ->get();
        // dd($results);
        return view('result.exam-result',compact('results','students','examSchedule'));

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
        $subjects = $request->input('subjects');


        $dateSheets = DateSheet::where('exam_schedule_id', $exam->id)->get();

        foreach ($subjects as $index => $subjectData) {
            $dateSheet = $dateSheets[$index] ?? new DateSheet();
            $dateSheet->exam_schedule_id = $exam->id;
            $dateSheet->subject_id = $subjectData['subject_id'] ?? null;
            $dateSheet->date = $subjectData['date'] ?? null;
            $dateSheet->start_time = $subjectData['start_time'] ?? null;
            $dateSheet->end_time = $subjectData['end_time'] ?? null;

            // Check if any of the critical fields are null
            if (is_null($dateSheet->subject_id) || is_null($dateSheet->date) || is_null($dateSheet->start_time) || is_null($dateSheet->end_time)) {
                return redirect()->back()->withErrors('All fields are required.');
            }

            $dateSheet->save();
        }

        return redirect()->back()->with('success', 'Exam schedule updated successfully!');
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
