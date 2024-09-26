<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Result;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $exams = Exam::get();
        $subjects = Subject::get();
        $classe = Classe::get();
        $sections = Section::get();

        return view('result.result', compact('exams', 'subjects', 'classe', 'sections'));
    }

    public function add(Request $request)
    {

        $exam_id = $request->exam;
        $subject_id = $request->subject;
        $class_id = $request->class;
        $section_id = $request->section;
        $exam = Exam::find($exam_id);
        $subject = Subject::find($subject_id);
        $class = Classe::find($class_id);
        $section = Section::find($section_id);
        $students = Student::where('class_id', $class->id)->where('section_id', $section->id)->get();

        return view('result.student', compact('exam', 'subject', 'class', 'section', 'students'));

    }

    public function store(Request $request)
    {
        $examId = $request->exam;
        $subjectId = $request->subject;
        $classId = $request->class;
        $sectionId = $request->section;
        $results = [];
        foreach ($request->students as $studentData) {

            $obtMarks = $studentData['obt_marks'];
            $totalMarks = $studentData['total'];
            $grade = $this->determineGrade($obtMarks / $totalMarks * 100);
            $results[] = [
                'exam_id' => $examId,
                'subject_id' => $subjectId,
                'class_id' => $classId,
                'section_id' => $sectionId,
                'student_id' => $studentData['student_id'],
                'obt_marks' => $obtMarks,
                'total' => $totalMarks,
                'grade' => $grade,
            ];
        }
        Result::insert($results);

        return redirect('result')->with('message', 'Marks successfully added for all students');
    }

    private function determineGrade($totalMarks)
    {
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

    public function list(Request $request)
    {
        $classes = Classe::get();
        $sections = Section::get();

        $query = Student::with('class', 'section', 'exam');
        if ($request->has('class') && ! empty($request->input('class'))) {
            $query->where('class_id', $request->input('class'));
        }
        if ($request->has('section') && ! empty($request->input('section'))) {
            $query->where('section_id', $request->input('section'));
        }

        $students = $query->get();

        $exams = ExamSchedule::get();

        return view('result.resultlist', compact('students', 'exams', 'classes', 'sections'));
    }

    public function view(Request $request, $id)
    {
        $student = Student::find($id);
        $exams = Exam::get();
        $query = Result::where('student_id', $id)->with('exam', 'student', 'class', 'section');
        if ($request->has('exam') && ! empty($request->input('exam'))) {
            $query->where('exam_id', $request->input('exam'));
        }
        $results = $query->get();

        return view('result.view', compact('results', 'exams', 'student'));

    }

    public function showResultCard(Request $request)
    {
        $studentId = $request->input('student_id');
        $examId = $request->input('exam');

        $student = Student::findOrFail($studentId);
        $exam = Exam::findOrFail($examId);

        $results = Result::where('student_id', $studentId)
            ->where('exam_id', $examId)
            ->get();

        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return view('partials.result_table', compact('exam', 'results'))->render();
        }

        return view('result.card', compact('student', 'exam', 'results'));
    }

    public function notFound()
    {
        return redirect()->back()->with('message', 'Student did not attempt Exam');
    }
}
