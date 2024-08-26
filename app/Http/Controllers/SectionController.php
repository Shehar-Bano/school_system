<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Section;
use App\Models\Employee;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(){
        $teacher= Employee::get();
        $class = Classe::get();
        return view('section.section', compact('teacher','class'));
    }
    public function list(){
        $sections = Section::with('employee','classe')->get();

        return view('section.sectionlist',compact('sections'));
     }
     public function store(Request $request) {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'employ' => 'required|exists:employees,id',
            'class' => 'required|exists:classes,id',
            'note' => 'nullable|string|max:500',
        ]);

        // Check if the section already exists
        $existingSection = Section::where('name', $validatedData['name'])
            ->where('classe_id', $validatedData['class'])
            ->first();

        if ($existingSection) {
            return redirect()->back()->withErrors(['name' => 'This section already exists!'])->withInput();
        }

        // Create a new Section with the validated data
        $section = new Section();
        $section->name = $validatedData['name'];
        $section->capacity = $validatedData['capacity'];
        $section->employee_id = $validatedData['employ'];
        $section->classe_id = $validatedData['class'];
        $section->note = $validatedData['note'] ?? null; // Note is nullable
        $section->save();

        return redirect()->back()->with('message', 'Section successfully added!');
    }

     public function del($id){
        $section = Section::find($id);
        $section->delete();
        return redirect()->back()->with('message','class deleted successfully');
     }
     public function edit($id){
        $teacher= Employee::get();
        $class = Classe::get();
        $section = Section::with('employee','classe')->findOrFail($id);
       return view('section.editsection',compact('section','teacher','class'));
     }
     public function update(Request $request, $id) {
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
            ->where('id', '!=', $id) // Exclude the current section from the check
            ->first();

        if ($existingSection) {
            return redirect()->back()->withErrors(['name' => 'This section already exists!'])->withInput();
        }

        // Update the section with the validated data
        $section->name = $validatedData['name'];
        $section->capacity = $validatedData['capacity'];
        $section->employee_id = $validatedData['employ'];
        $section->classe_id = $validatedData['class'];
        $section->note = $validatedData['note'] ?? null; // Note is nullable
        $section->save();

        return redirect()->back()->with('message', 'Section successfully updated!');
    }

}
