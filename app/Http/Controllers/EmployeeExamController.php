<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\DateSheet;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Result;

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
public function sheduleDelete($id){
    $examSchedule = ExamSchedule::find($id);
    $examSchedule->delete();
    return redirect()->back()->with('message', 'Exam Schedule deleted successfully!');

}

public function sheduleEdit($id)
    {
        $schedule = ExamSchedule::find($id);
        $sections= Section::get();
        $classes = Classe::get();

        $exams = Exam::get();
        return view('employeeDashboard.shedules.edit', compact('classes','sections','exams','schedule'));
    }
    public function sheduleUpdate(Request $request, $id)
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
    ////////printlist
    public function resultPrint($id){

        $students = Student::with('class', 'section', 'exam')->get();
        $examSchedule =ExamSchedule::find($id);
        $results = Result::where('exam_id', $examSchedule->exam_id)
        ->where('class_id',$examSchedule->class_id)
        ->with(['subject', 'student','exam'])
        ->get();
        // dd($results);
        return view('employeeDashboard.result.printList',compact('results','students','examSchedule'));
    }
    ////////////////datesheet
    public function dateSheetAdd($id){
        $exam = ExamSchedule::find($id);
        $subjects = Subject::get();
        return view('employeeDashboard.dateSheet.add',compact('exam','subjects'));
    }

    public function dateSheetStore(Request $request, $id) {
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

    public function dateSheetList($id)
    {
        $exams = ExamSchedule::find($id);


        $datesheets = DateSheet::with('subject')->get();
        return view('employeeDashboard.dateSheet.index',compact('exams','datesheets'));
    }
    public function dateSheetDelete($id){
        $dateSheet = DateSheet::find($id);
        $dateSheet->delete();
        return redirect()->back()->with('message', 'Exam Schedule deleted successfully!');
    }
    public function dateSheetEdit($id){
        $exams = ExamSchedule::find($id);
        $datesheets = DateSheet::with('subject')->get();
        return view('employeeDashboard.dateSheet.edit',compact('exams','datesheets'));

    }
    public function dateSheetUpdate(Request $request, $id){            
            $exam = DateSheet::where('id', $id)->first();
            $exam->date = $request->date;
            $exam->start_time = $request->start_time;
            $exam->end_time = $request->end_time;
            $exam->save();
        return redirect()->back()->with('success', 'Exam schedule updated successfully!');
    }
    /////////////////////Results
    public function resultList(Request $request){
        $classes = Classe::get();
        $sections = Section::get();

        $query = Student::with('class', 'section', 'exam');
        if ($request->has('class') && !empty($request->input('class'))) {
            $query->where('class_id', $request->input('class'));
        }
        if ($request->has('section') && !empty($request->input('section'))) {
            $query->where('section_id', $request->input('section'));
        }

        $students = $query->get();


        $exams = ExamSchedule::get();
        return view('employeeDashboard.result.index', compact('students', 'exams', 'classes', 'sections'));
    
    }

    public function resultAdd()   {
        $exams = Exam::get();
        $subjects = Subject::get();
        $classe = Classe::get();
        $sections =Section::get();
        return view('employeeDashboard.result.add',compact('exams','subjects','classe','sections'));
    }
    public function resultStore(Request $request){
        $examId = $request->exam;
        $subjectId = $request->subject;
        $classId = $request->class;
        $sectionId = $request->section;
        $results = [];
        foreach ($request->students as $studentData) {

            $obtMarks = $studentData['obt_marks'];
            $totalMarks = $studentData['total'];
            $grade = $this->determineGrade($obtMarks/$totalMarks * 100);
            $results[] = [
                'exam_id' => $examId,
                'subject_id' => $subjectId,
                'class_id' => $classId,
                'section_id' => $sectionId,
                'student_id' => $studentData['student_id'],
                'obt_marks' => $obtMarks,
                'total' =>  $totalMarks,
                'grade' => $grade,
            ];
        }
        Result::insert($results);
        return redirect()->back()->with('message', 'Marks successfully added for all students');
    }
    private function determineGrade($totalMarks) {
        if ($totalMarks >= 90) {
            return 'A';
        } elseif ($totalMarks >= 80) {
            return 'B';
        } elseif ($totalMarks >= 60) {
            return 'C';
        } elseif ($totalMarks >= 40) {
            return 'D';
        } else {
            return 'F';
        }
    }
    public function addstudent(Request $request){

        $exam_id = $request->exam;
        $subject_id = $request->subject;
        $class_id =$request->class;
        $section_id = $request->section;
        $exam = Exam::find($exam_id);
        $subject = Subject::find($subject_id);
        $class =  Classe::find($class_id);
        $section = Section::find($section_id);
        $students = Student::where('class_id',$class->id)->where('section_id',$section->id)->get();
        return view('employeeDashboard.result.addStudent',compact('exam','subject','class','section','students'));


    }
    public function viewResult(Request $request,$id){
        $student=Student::find($id);
        $exams=Exam::get();
        $query = Result::where('student_id',$id)->with('exam','student','class','section');
        if ($request->has('exam') && !empty($request->input('exam'))) {
            $query->where('exam_id', $request->input('exam'));
        }
        $results = $query->get();


        return view('employeeDashboard.result.viewResult',compact('results','exams','student'));

    }

}
