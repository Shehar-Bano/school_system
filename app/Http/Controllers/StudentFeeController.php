<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Exam;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentFee;
use App\Models\StudentTransaction;
use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
    
    public function index(){
        $sections=Section::with('classe')->get();
        $classes=classe::get();
        return view('studentfee.index',compact('sections','classes'));
    }

    public function listStudent($id)
    {
        
        $section = Section::with('student', 'classe')->findOrFail($id);
        $students = $section->student;
        $examFee = Exam::sum('exam_fee');
        $studentfee = StudentFee::select('student_id', 'date')->get();        
        $studentData = $students->map(function ($student) use ($examFee) {
            
                        $totalFine = StudentTransaction::where('student_id', $student->id)
                ->where('transaction_type', 'fine')
                ->sum('amount');
    
            $totalFund = StudentTransaction::where('student_id', $student->id)
                ->where('transaction_type', '!=', 'fine')
                ->sum('amount');
    
            
            $tuitionFee = $student->tution_fee ?? 0;
    

            return [
                'date' => now(),
                'student_id' => $student->id,
                'student' => $student,
                'totalFine' => $totalFine,
                'totalFund' => $totalFund,
                'tuitionFee' => $tuitionFee,
                'examFee' => $examFee,
                'paymentStatus' => 'pending',
            ];
        });
        return view('studentfee.liststudent', [
            'studentData' => $studentData,
            'section' => $section,
            'studentfees' => $studentfee
        ]);
    }
    

    public function feeRecive(Request $request,$id){
        $total=$request->total;
       
        $student=Student::find($id);
        StudentFee::create([
            'student_id'=>$student->id,
            'total'=>$total,
            'date'=>now()

        ]);
        return redirect()->back()->with('success','Fee received successfully');
        

    }
    
}
