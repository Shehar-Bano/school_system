<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function assignmentView(){
        $assignments=Assignment::get();
        return view('assignment.view',compact('assignments'));

    }
}
