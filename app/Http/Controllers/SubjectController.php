<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Employee;
use App\Models\Subject;
use Illuminate\Http\Request;
use Mockery\Matcher\Subset;

class SubjectController extends Controller
{
    public function subjectView(){
        $subjects=Subject::get();
        return view('subject.viewAll',compact('subjects'));
    }
    public function addSubjectView(){
        $employees=Employee::with('designation')->get();
        $classes=classe::get();
        return view('subject.add',compact('employees','classes'));
    }
    public function subjectStore(Request $request) {
        $request->validate([
            'subject_name' => 'required',
                        'final_marks' => 'required|integer',
            'pass_marks' => 'required|integer',
            'sub_code' => 'required',
            'type' => 'required',
        ]);
    
        $subject = new Subject();
        $subject->subject_name = $request->subject_name;
     
        $subject->final_marks = $request->final_marks;
        $subject->pass_marks = $request->pass_marks;
        $subject->sub_code = $request->sub_code;
        $subject->type = $request->type;
        $subject->save();
    
        return redirect()->back()->with('message', 'Subject Added Successfully');
    }
    
    public function editSubjectView($id){
        $subject=Subject::find($id);
        $employees=Employee::with('designation')->get();
        $classes=classe::get();
       
        return view('subject.edit',compact('subject','employees','classes'));
    }
    public function subjectUpdate(Request $request, $id){
        $request->validate([
            'subject_name' => 'required',
           
            'final_marks' => 'required|integer',
            'pass_marks' => 'required|integer',
            'sub_code' => 'required',
            'type' => 'required',
        ]);
    
        $subject =Subject::findOrFail($id);
        $subject->subject_name = $request->subject_name;
        $subject->final_marks = $request->final_marks;
        $subject->pass_marks = $request->pass_marks;
        $subject->sub_code = $request->sub_code;
        $subject->type = $request->type;
        $subject->save();
        return redirect()->back()->with('message', 'Subject Updated Successfully');


    }
    public function subjectDelete($id){
    $id=Subject::findOrFail($id);
    $id->delete();
    return redirect()->back()->with('message', 'Subject Deleted Successfully');
     }
}
