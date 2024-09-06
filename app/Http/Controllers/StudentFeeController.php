<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class StudentFeeController extends Controller
{
    public function index(){
        $sections=Section::with('class_id')->get();

        return view('studentfee.index');
    }
}
