<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\classe;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function assignmentView(){
        $assignments=Assignment::get();
        return view('assignment.view',compact('assignments'));

    }
    public function addAssignmentView(){
        $classes=classe::get();
        $sections=Section::get();
        $subjects=Subject::get();
        return view('assignment.add',compact('classes','sections','subjects'));
        
        }
        public function assignmentStore(Request $request){
            $request->validate([
                'title'=>'required',
                'description'=>'required',
                'class_id'=>'required',
                'section_id'=>'required',
                'subject_id'=>'required',
                'deadline'=>'required',
                'assignment'=>'required',
            ]);
            $uploader=Auth::user();
            $assignment=new Assignment();
            $assignment->uploader=$uploader->name;
            $assignment->title=$request->title;
            $assignment->description=$request->description;
            $assignment->class_id=$request->class_id;
            $assignment->section_id=$request->section_id;
            $assignment->subject_id=$request->subject_id;
            $assignment->deadline=$request->deadline;
            $file = $request->file('assignment');
            $assignmentPath = $file->store('Assignments', 'public');
            $assignment->assignment = $assignmentPath;
            $assignment->save();
            return redirect()->back()->with('message','Assignment Added Succesfully!');
        }
        public function assignmentDelete($id){
            $assignment=Assignment::find($id);
            $assignment->delete();
                return redirect()->back()->with('message','Assignment Deleted Succesfully!');
        }
        public function editAssignmentView($id){
            $assignment=Assignment::with('subject','section','class')->find($id);
            $classes=classe::get();
            $sections=Section::get();
            $subjects=Subject::get();
            return view('assignment.edit',compact('assignment','classes','sections','subjects'));
     }
     public function assignmentUpdate(Request $request,$id){
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'class_id'=>'required',
            'section_id'=>'required',
            'subject_id'=>'required',
            'deadline'=>'required',
           
            ]);
            $assignment=Assignment::find($id);
            $assignment->title=$request->title;
            $assignment->description=$request->description;
            $assignment->class_id=$request->class_id;
            $assignment->section_id=$request->section_id;
            $assignment->subject_id=$request->subject_id;
            $assignment->deadline=$request->deadline;
            $file = $request->file('assignment');
            if($file){
                $assignmentPath = $file->store('Assignments', 'public');
                $assignment->assignment = $assignmentPath;
                }
                $assignment->save();
                return redirect()->back()->with('message','Assignment Updated Succesfully!');
                }
   public function assignmetDetail($id){
    $assignment=Assignment::with('subject','section','class')->find($id);
    return view('assignment.detail',compact('assignment'))->with('message','Assignment Updated Succesfully!');
                  
   }                 
}
