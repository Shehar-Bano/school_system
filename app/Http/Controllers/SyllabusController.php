<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SyllabusController extends Controller
{
    public function syllabusView()
    {
        if (auth()->check() && !auth()->user()->can('academic.syllabus.view')) {
            abort(403, 'Unauthorized: You do not have permission to view syllabus.');
        }

        $syllabuses = Syllabus::get();

        return view('syllabus.view', compact('syllabuses'));
    }

    public function addSyllabusView()
    {
        if (auth()->check() && !auth()->user()->can('academic.syllabus.create')) {
            abort(403, 'Unauthorized: You do not have permission to create syllabus.');
        }

        $classes = classe::get();

        return view('syllabus.add', compact('classes'));
    }

    public function syllabusStore(Request $request)
    {
        if (auth()->check() && !auth()->user()->can('academic.syllabus.create')) {
            abort(403, 'Unauthorized: You do not have permission to create syllabus.');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'class_id' => 'required',
            'file' => 'required',

        ]);
        $uploader = Auth::user();
        $syllabus = new Syllabus;
        $syllabus->title = $request->title;
        $syllabus->description = $request->description;
        $syllabus->class_id = $request->class_id;
        $file = $request->file('file');
        $filePath = $file->store('files', 'public');
        $syllabus->file = $filePath;
        $syllabus->uploader = $uploader ? $uploader->name : 'Admin';
        $syllabus->date = now();
        $syllabus->save();

        return redirect()->back()->with('message', 'Syllabus added successfully');

    }

    public function editsyllabusView($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.syllabus.edit')) {
            abort(403, 'Unauthorized: You do not have permission to edit syllabus.');
        }

        $classes = classe::get();
        $syllabus = Syllabus::findOrFail($id);

        return view('syllabus.edit', compact('classes', 'syllabus'));

    }

    public function syllabusUpdate(Request $request, $id)
    {
        if (auth()->check() && !auth()->user()->can('academic.syllabus.edit')) {
            abort(403, 'Unauthorized: You do not have permission to update syllabus.');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'class_id' => 'required',

        ]);
        $uploader = Auth::user();
        $syllabus = Syllabus::findOrFail($id);
        $syllabus->title = $request->title;
        $syllabus->description = $request->description;
        $syllabus->class_id = $request->class_id;
        if ($request->file) {
            $file = $request->file('file');
            $filePath = $file->store('files', 'public');
            $syllabus->file = $filePath;
        }

        $syllabus->uploader = $uploader ? $uploader->name : $syllabus->uploader;
        $syllabus->date = now();
        $syllabus->save();

        return redirect()->back()->with('message', 'Syllabus updated successfully');

    }

    public function syllabusDelete($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.syllabus.delete')) {
            abort(403, 'Unauthorized: You do not have permission to delete syllabus.');
        }

        $id = Syllabus::findOrFail($id);
        $id->delete();

        return redirect()->back()->with('message', 'Syllabus Deleted successfully');

    }

    public function downloadFile($file)
    {
        if (auth()->check() && !auth()->user()->can('academic.syllabus.download')) {
            abort(403, 'Unauthorized: You do not have permission to download syllabus files.');
        }

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

    public function syllabusDetail($id)
    {
        if (auth()->check() && !auth()->user()->can('academic.syllabus.detail') && !auth()->user()->can('academic.syllabus.view')) {
            abort(403, 'Unauthorized: You do not have permission to view syllabus details.');
        }

        $syllabus = Syllabus::findOrFail($id);

        return view('syllabus.detail', compact('syllabus'));

    }
}
