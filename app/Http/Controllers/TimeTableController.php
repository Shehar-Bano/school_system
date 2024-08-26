<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\ClassesSubject;
use App\Models\Employee;
use App\Models\Section;
use App\Models\Subject;
use App\Models\TimeTable;
use Illuminate\Http\Request;

class TimeTableController extends Controller

{
    public function timeTableActions(Request $request) {
        // Initialize the query with relationships
        $query = TimeTable::with('subject', 'teacher', 'class', 'section');
        
        // Apply filters based on user input
        if ($request->has('class') && !empty($request->input('class'))) {
            $query->where('class_id', $request->input('class'));
        }
    
        if ($request->has('section') && !empty($request->input('section'))) {
            $query->where('section_id', $request->input('section'));
        }
    
        if ($request->has('teacher') && !empty($request->input('teacher'))) {
            $query->where('teacher_id', $request->input('teacher'));
        }
    
        // Execute the query and get the filtered timetables
        $timetables = $query->get();
    
        // Get all necessary data for the filters
        $classes = Classe::all();
        $sections = Section::all();
        $employees = Employee::all();
        $subjects = Subject::all();
    
        // Return the view with the filtered timetables and the filter data
        return view('timeTable.timeTableAction', compact('timetables', 'classes', 'sections', 'employees', 'subjects'));
    }
    
    
    
    public function timeTableView(Request $request){
        // Initialize the query builder with relationships
        $query = TimeTable::with('subject', 'teacher', 'class', 'section');
        
        // Apply default filter for Class 1
        $classId = 6; 
        if ($request->has('class') && !empty($request->input('class'))) {
            $classId = $request->input('class');
        }
        $query->where('class_id', $classId);
        
        if ($request->has('section') && !empty($request->input('section'))) {
            $query->where('section_id', $request->input('section'));
        }
        
        if ($request->has('teacher') && !empty($request->input('teacher'))) {
            $query->where('teacher_id', $request->input('teacher'));
        }
        
        // Fetch the filtered results
        $timetables = $query->get();
        
        // Fetch all classes, sections, and employees
        $classes = Classe::all();
        $sections = Section::all();
        $subjects = Subject::all();
        $staticSubjects = [ 'Urdu','English', 'Science','Drawing','Social Study','Math'];
        $employees = Employee::with('designation')->get(); // Ensure the employee model includes the designation relationship
        
        // Pass the data to the view
        return view('timeTable.classView', compact('timetables', 'classes', 'subjects','sections', 'employees','staticSubjects'));
    }


    public function timeTableViewTeacher(Request $request)
{
    // Initialize the query builder with relationships
    $query = TimeTable::with('subject', 'teacher', 'class', 'section');

    // Apply default filter for teacher_id = 1
    if (!$request->has('teacher') || empty($request->input('teacher'))) {
        $query->where('teacher_id', 1);
    }

    // Apply filters for class and section
    if ($request->has('class') && !empty($request->input('class'))) {
        $query->where('class_id', $request->input('class'));
    }

    if ($request->has('section') && !empty($request->input('section'))) {
        $query->where('section_id', $request->input('section'));
    }

    // Apply filter for teacher
    if ($request->has('teacher') && !empty($request->input('teacher'))) {
        $query->where('teacher_id', $request->input('teacher'));
    }

    // Fetch the filtered results
    $timetables = $query->get();

    // Fetch all classes, sections, and employees
    $classes = Classe::all();
    $sections = Section::all();
    $subjects = Subject::all();

    $employees = Employee::with('designation')->get(); // Ensure the employee model includes the designation relationship

    // Pass the data to the view
    return view('timeTable.teacherView', compact('timetables', 'classes', 'subjects', 'sections', 'employees'));
}
    
    public function addTimeTableView(){
        $employees=Employee::with('designation')->get();
        $classes=classe::get();
        $sections=Section::get();
        $subjects=ClassesSubject::get();
        
        return view('timeTable.add',compact('employees','classes','sections','subjects',));
    }
    public function timeTableStore(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
    
        $existingSchedule = TimeTable::where('teacher_id', $request->teacher_id)->where('slot_status','allocated')
            ->where('day', $request->day)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->first();
    
        if ($existingSchedule) {
            return redirect()->back()->with('error', 'Teacher already has a class on this Shedule');
        }
    
        TimeTable::create($request->all());
        return redirect()->back()->with('success', 'Time Table Added Successfully');
    }

    public function editTimeTableView($id){
        $timetable = TimeTable::with('subject', 'teacher', 'class', 'section')->findOrFail($id);
        $employees=Employee::with('designation')->get();
        $classes=classe::get();
        $sections=Section::get();
        $subjects=ClassesSubject::get();
        return view('timeTable.edit',compact('timetable','employees','classes','sections','subjects'));


    }
    public function timeTableUpdate(Request $request, $id){
        $request->validate([
            'teacher_id'=>'required',
            'class_id'=>'required',
            'section_id'=>'required',
            'subject_id'=>'required',
            'day'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            ]);
            TimeTable::findOrFail($id)->update($request->all());
            return redirect()->back()->with('success','Time Table Added Successfully');
        } 

        public function timeTableDelete($id){
            $id=TimeTable::findOrFail($id);
            $id->delete();
            return redirect()->back()->with('success','Time Table Deleted Successfully');
        }

    public function timetableFreeSlot($id){
        $timetable=TimeTable::findOrFail($id);
        $timetable->slot_status="available";
        $timetable->save();
        return redirect()->back()->with('message','Slot is now available');

    }
public function timetableOccupySlot($id){
    $timetable=TimeTable::findOrFail($id);
    $timetable->slot_status="allocated";
    $timetable->save();
    return redirect()->back()->with('message','Slot is now allocated');
}
}
