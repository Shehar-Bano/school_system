<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Taxe;
use App\Models\classe;
use App\Models\Section;
use App\Models\Student;
use App\Models\TaxeFee;
use App\Models\StudentFee;
use Illuminate\Http\Request;
use App\Models\StudentTransaction;

class TaxeFeeController extends Controller
{
    public function index(){
        $sections=Section::with('classe')->get();
        $classes=classe::get();
        return view('studentfee.taxe-index',compact('sections','classes'));
    }


    public function listStudent($id)
    {
        // Fetch section with students and classes
        $section = Section::with('student', 'classe')->findOrFail($id);
        $students = $section->student;

        // Get the total taxes and fees from the TaxeFee table
        $taxeFees = Taxe::first();  // Assuming there's only one row in the TaxeFee table.

        // Map through each student to calculate fees
        $studentData = $students->map(function ($student) use ($taxeFees) {

            // Calculate total fee using fees from the TaxeFee
            $totalFee =   $taxeFees->bus_taxes
                        + $taxeFees->other_activity
                        + $taxeFees->lunch
                        + $taxeFees->admission_fee
                        + $taxeFees->library_tax;

            return [
                'date' => now(),
                'student_id' => $student->id,
                'student' => $student,
                'bus_taxes' => $taxeFees->bus_taxes,
                'admission_tax' => $taxeFees->admission_fee,
                'other_activity_tax' => $taxeFees->other_activity,
                'lunch' => $taxeFees->lunch,
                'library_tax' => $taxeFees->library_tax,
                'totalFee' => $totalFee, // Include total fee calculation
                'paymentStatus' => 'pending',
            ];
        });

        // Return the view with student data, section, and student fees
        return view('studentfee.taxe-list', [
            'studentData' => $studentData,
            'section' => $section,
            'taxeFees' => $taxeFees
        ]);
    }

    public function feeRecive(Request $request, $id)
    {
        $total = $request->total;
        $student = Student::find($id);

        // Store fee details in TaxeFee table
        TaxeFee::create([
            'student_id' => $student->id,
            'total' => $total,
            'date' => now()
        ]);
       

        return redirect()->back()->with('success', 'Fee received successfully');
    }

}
