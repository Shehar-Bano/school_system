<?php

namespace App\Http\Controllers;


use App\Models\classe;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class SyllabusController extends Controller
{
    public function syllabusView(){
        $syllabuses=Syllabus::get();
        return view('syllabus.view',compact('syllabuses'));
    }
    public function addSyllabusView(){
        $classes=classe::get();
        return view('syllabus.add',compact('classes'));
        }
        public function syllabusStore(Request $request){
            $request->validate([
                'title'=>'required',
                'description'=>'required',
                'class_id'=>'required',
                'file'=>'required',

            ]);
            $uploader=Auth::user();
            $syllabus=new Syllabus();
            $syllabus->title=$request->title;
            $syllabus->description=$request->description;
            $syllabus->class_id=$request->class_id;
            $file=$request->file('file');
            $filePath=$file->store('files','public');
            $syllabus->file=$filePath;
            $syllabus->uploader=$uploader->name;
            $syllabus->date=now();
            $syllabus->save();
            return redirect()->back()->with('message','Syllabus added successfully');

        }

        public function editsyllabusView($id){
            $classes=classe::get();
            $syllabus=Syllabus::findOrFail($id);
            return view('syllabus.edit',compact('classes','syllabus'));

        }

        public function syllabusUpdate(Request $request,$id){

          
                $request->validate([
                    'title'=>'required',
                    'description'=>'required',
                    'class_id'=>'required',
    
                ]);
                $uploader=Auth::user();
                $syllabus=Syllabus::findOrFail($id);
                $syllabus->title=$request->title;
                $syllabus->description=$request->description;
                $syllabus->class_id=$request->class_id;
                if($request->file){
                    $file=$request->file('file');
                    $filePath=$file->store('files','public');
                    $syllabus->file=$filePath;
                }
             
                $syllabus->uploader=$uploader->name;
                $syllabus->date=now();
                $syllabus->save();
                return redirect()->back()->with('message','Syllabus added successfully');
    
        }
    public function syllabusDelete($id){
        $id=Syllabus::findOrFail($id);
        $id->delete();
        return redirect()->back()->with('message','Syllabus Deleted successfully');



    }
    public function downloadFile($file)
    {
        $filePath = storage_path("app/public/files/{$file}");
        $fileInfo = \Illuminate\Support\Facades\Storage::getFileInfo($filePath);
    
        if ($fileInfo) {
            $headers = [
                'Content-Type' => $fileInfo->mimeType,
                'Content-Disposition' => "attachment; filename={$fileInfo->basename}",
            ];
    
            return response()->download($filePath, $fileInfo->basename, $headers);
        } else {
            abort(404, 'File not found');
        }
    }

    public function syllabusDetail($id){
        $syllabus=Syllabus::findOrFail($id);
        return view('syllabus.detail',compact('syllabus'));

    }
}
    
