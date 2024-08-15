<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\classe;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

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
}
