<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\DateSheet;
use App\Models\ExamSchedule;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /////////////////admission report

    public function admissionReport(Request $request)
    {
        $sections = Section::get();
        $classes = Classe::get();
        $query = Student::with('section', 'class');
        if ($request->has('class') && ! empty($request->input('class'))) {
            $query->where('class_id', $request->input('class'));
        }
        if ($request->has('section') && ! empty($request->input('section'))) {
            $query->where('section_id', $request->input('section'));
        }
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        $students = $query->get();

        return view('report.admission_report', compact('classes', 'sections', 'students'));

    }

    ////////////////////result report
    public function resultReport(Request $request)
    {
        $sections = Section::all();
        $classes = Classe::all();

        // Build the query for exams with the necessary relationships
        $query = ExamSchedule::with('section', 'class');
        if ($request->has('class') && ! empty($request->input('class'))) {
            $query->where('class_id', $request->input('class'));
        }
        if ($request->has('section') && ! empty($request->input('section'))) {
            $query->where('section_id', $request->input('section'));
        }
        $exams = $query->get();
        $attendences = $exams->map(function ($exam) {
            $dateSheets = DateSheet::where('exam_schedule_id', $exam->id)->get();

            return $dateSheets->map(function ($dateSheet) {
                return StudentAttendance::where('date', $dateSheet->date)->get();
            });
        })->flatten(2);

        return view('report.result_report', compact('exams', 'classes', 'sections', 'attendences'));
    }
}
