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
        // Fetch section with students and classes
        $section = Section::with('student', 'classe')->findOrFail($id);
        $students = $section->student;
        
        // Get total exam fee
        $examFee = Exam::sum('exam_fee');
        
        // Get all student fee records (if needed)
        $studentfee = StudentFee::select('student_id', 'date')->get();        
    
        // Map through each student to calculate fees
        $studentData = $students->map(function ($student) use ($examFee) {
            // Get total fine for the student
            $totalFine = StudentTransaction::where('student_id', $student->id)
                ->where('transaction_type', 'fine')
                ->sum('amount');
    
            // Get total fund for the student (excluding fines)
            $totalFund = StudentTransaction::where('student_id', $student->id)
                ->where('transaction_type', '!=', 'fine')
                ->sum('amount');
    
            // Get the student's tuition fee, or 0 if it's null
            $tuitionFee = $student->tution_fee ?? 0;
    
            // Calculate total fee: tuitionFee + totalFine + totalFund + examFee
            $totalFee = $tuitionFee + $totalFine + $examFee - $totalFund;
    
            return [
                'date' => now(),
                'student_id' => $student->id,
                'student' => $student,
                'totalFine' => $totalFine,
                'totalFund' => $totalFund,
                'tuitionFee' => $tuitionFee,
                'examFee' => $examFee,
                'totalFee' => $totalFee, // Include total fee calculation
                'paymentStatus' => 'pending',
            ];
        });
    
        // Return the view with student data, section, and student fees
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
