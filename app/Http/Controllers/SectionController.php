<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Employee;
use App\Models\Section;
use App\Models\StudentTransaction;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        if (auth()->check() && !auth()->user()->can('academic.section.create')) {
            abort(403, 'Unauthorized: You do not have permission to create sections.');
        }

        $teacher = Employee::with('designation')->get();
        $class = Classe::get();

        // Get all sections with assigned incharge to detect and prevent conflicts
        $assignedTeachers = Section::with(['classe', 'employee'])
            ->whereNotNull('employee_id')
            ->get()
            ->keyBy('employee_id');

        return view('section.section', compact('teacher', 'class', 'assignedTeachers'));
    }

    public function list()
    {
        if (auth()->check() && !auth()->user()->can('academic.section.view')) {
            abort(403, 'Unauthorized: You do not have permission to view sections.');
        }

        $sections = Section::with('employee', 'classe')->get();

        return view('section.sectionlist', compact('sections'));
    }

    public function store(Request $request)
    {
        if (auth()->check() && !auth()->user()->can('academic.section.create')) {
            abort(403, 'Unauthorized: You do not have permission to create sections.');
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'employ' => 'required|exists:employees,id',
            'class' => 'required|exists:classes,id',
            'note' => 'nullable|string|max:500',
        ]);

        // Check if the section already exists in the same class
        $existingSection = Section::where('name', $validatedData['name'])
            ->where('classe_id', $validatedData['class'])
            ->first();

        if ($existingSection) {
            return redirect()->back()->withErrors(['name' => 'This section name already exists for the selected class!'])->withInput();
        }

        // Check if the selected teacher/professor is already assigned as incharge in another section
        $alreadyAssigned = Section::with(['classe', 'employee'])
            ->where('employee_id', $validatedData['employ'])
            ->first();

        if ($alreadyAssigned) {
            $teacherName = $alreadyAssigned->employee->name ?? 'This teacher';
            $className = $alreadyAssigned->classe->name ?? 'another class';
            $secName = $alreadyAssigned->name ?? 'Section';
            $errorMsg = "Professor {$teacherName} is already assigned as Incharge for {$className} - {$secName}. Please select another professor / teacher.";

            return redirect()->back()
                ->withErrors(['employ' => $errorMsg])
                ->with('error', $errorMsg)
                ->withInput();
        }

        // Create a new Section with the validated data
        $section = new Section;
        $section->name = $validatedData['name'];
        $section->capacity = $validatedData['capacity'];
        $section->employee_id = $validatedData['employ'];
        $section->classe_id = $validatedData['class'];
        $section->note = $validatedData['note'] ?? null;
        $section->save();

        return redirect()->route('section-list')->with('message', 'Section successfully added!');
    }

    public function del($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.section.delete')) {
            abort(403, 'Unauthorized: You do not have permission to delete sections.');
        }

        $section = Section::find($id);
        $section->delete();

        return redirect()->back()->with('message', 'Section deleted successfully');
    }

    public function edit($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.section.edit')) {
            abort(403, 'Unauthorized: You do not have permission to edit sections.');
        }

        $teacher = Employee::with('designation')->get();
        $class = Classe::get();
        $section = Section::with('employee', 'classe')->findOrFail($id);

        // Get assigned incharges excluding the current section
        $assignedTeachers = Section::with(['classe', 'employee'])
            ->whereNotNull('employee_id')
            ->where('id', '!=', $id)
            ->get()
            ->keyBy('employee_id');

        return view('section.editsection', compact('section', 'teacher', 'class', 'assignedTeachers'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->check() && !auth()->user()->can('academic.section.edit')) {
            abort(403, 'Unauthorized: You do not have permission to update sections.');
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'employ' => 'required|exists:employees,id',
            'class' => 'required|exists:classes,id',
            'note' => 'nullable|string|max:500',
        ]);

        // Find the existing section
        $section = Section::findOrFail($id);

        // Check if another section with the same name and class already exists (excluding the current one)
        $existingSection = Section::where('name', $validatedData['name'])
            ->where('classe_id', $validatedData['class'])
            ->where('id', '!=', $id)
            ->first();

        if ($existingSection) {
            return redirect()->back()->withErrors(['name' => 'This section name already exists for the selected class!'])->withInput();
        }

        // Check if the selected teacher/professor is already assigned as incharge in another section
        $alreadyAssigned = Section::with(['classe', 'employee'])
            ->where('employee_id', $validatedData['employ'])
            ->where('id', '!=', $id)
            ->first();

        if ($alreadyAssigned) {
            $teacherName = $alreadyAssigned->employee->name ?? 'This teacher';
            $className = $alreadyAssigned->classe->name ?? 'another class';
            $secName = $alreadyAssigned->name ?? 'Section';
            $errorMsg = "Professor {$teacherName} is already assigned as Incharge for {$className} - {$secName}. Please select another professor / teacher.";

            return redirect()->back()
                ->withErrors(['employ' => $errorMsg])
                ->with('error', $errorMsg)
                ->withInput();
        }

        // Update the section with the validated data
        $section->name = $validatedData['name'];
        $section->capacity = $validatedData['capacity'];
        $section->employee_id = $validatedData['employ'];
        $section->classe_id = $validatedData['class'];
        $section->note = $validatedData['note'] ?? null;
        $section->save();

        return redirect()->route('section-list')->with('message', 'Section successfully updated!');
    }

    public function generateFeeSlips($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.section.fee')) {
            abort(403, 'Unauthorized: You do not have permission to generate section fee slips.');
        }

        $section = Section::with('student', 'classe')->findOrFail($id);
        $studentData = $section->student;
        $fines = StudentTransaction::with('student')->where('transaction_type', 'fine')->get();
        $funds = StudentTransaction::with('student')->where('transaction_type', '!=', 'fine')->get();

        $students = [];
        foreach ($studentData as $student) {
            $students[] = [
                'id' => $student->id,
                'name' => $student->name,
                'class' => $student->class,
                'roll_no' => $student->registration,
                'tuition_fee' => $student->tution_fee,
                'section' => $student->section,
                'funds' => $student->transaction->where('transaction_type', '!=', 'fine'),
            ];
        }

        $feeTypes = [
            'Admission' => 100, // static fee amount for admission
            'Other Activity' => 300, // static fee amount for school fees
            'School Bus' => 50, // static fee amount for school bus
            'Lunch' => 50, // static fee amount for lunch
            'Diary' => 50, // static fee amount for diary
            // add more fee types as needed
        ];

        $fees = [];
        foreach ($students as $student) {
            $studentFees = [];
            foreach ($feeTypes as $feeType => $amount) {
                $studentFees[] = [
                    'student_id' => $student['id'],
                    'fee_type' => $feeType,
                    'amount' => $amount,
                    'paid' => 0, // assuming paid amount is 0 for now
                ];
            }
            // Add tuition fee to the $studentFees array
            $studentFees[] = [
                'student_id' => $student['id'],
                'fee_type' => 'Tuition Fee',
                'amount' => $student['tuition_fee'],
                'paid' => 0, // assuming paid amount is 0 for now
            ];

            // Add transaction fee to the $studentFees array
            foreach ($fines as $fine) {
                if ($fine->student_id == $student['id']) {
                    $studentFees[] = [
                        'student_id' => $student['id'],
                        'fee_type' => 'Fine',
                        'amount' => $fine->amount,
                        'paid' => $fine->paid_amount, // assuming paid amount is stored in the transaction table
                    ];
                }
            }

            $fees[$student['id']] = $studentFees;
        }

        // Pass the dynamic data to the view
        return view('section.feeslip', compact('students', 'fees'));
    }
}
