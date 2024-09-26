<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $limit = $this->getValue($request->input('limit'));

            $students = Student::paginate($limit);

            if ($students->isEmpty()) {
                return ResponseHelper::error('No students found.', 404); // 404 Not Found
            }

            return ResponseHelper::success($students, 'students retrieved successfully', 200); // 200 OK

        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while fetching students.', 500, $e->getMessage()); // 500 Internal Server Error
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        try {
            $validated = $request->validated();
            if (Student::where('username', $request->input('username'))->exists()) {
                Alert::error('Username already exists', 'Please choose another username');

                return redirect()->back()->withInput(); // Redirect back with form data
            }

            $imagePath = $request->hasFile('image')
                ? $request->file('image')->store('students', 'public')
                : null;

            if ($validated) {
                Student::create([
                    'name' => $request->input('name'),
                    'gurdian' => $request->input('gurdian'),
                    'admissiondate' => $request->input('admissiondate'),
                    'dob' => $request->input('dob'),
                    'gender' => $request->input('gender'),
                    'religion' => $request->input('religion'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'class_id' => $request->input('class'),
                    'section_id' => $request->input('section'),
                    'group' => $request->input('group'),
                    'registration' => $request->input('registration'),
                    'tution_fee' => $request->input('tution_fee'),
                    'image' => $imagePath,
                    'username' => $request->input('username'),
                ]);

                return ResponseHelper::success('student created successfully', 200);
            } else {
                return ResponseHelper::error('validation failed', 404);
            }

        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while storing designations.', 500, $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $student = Student::find($id);
            if ($student) {
                return ResponseHelper::success($student, 200);

            } else {
                return ResponseHelper::error('student not found', 404);

            }
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while fetching student.', 500, $e->getMessage());

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreStudentRequest $request, $id)
    {
        try {
            $student = Student::find($id);
            $validated = $request->validated();
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $validated['image'] = $imagePath;
            }
            $student->update($validated);

            return ResponseHelper::success('Student updated successfully', 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Catch validation errors and return them as part of the response
            return ResponseHelper::error('Validation failed.', 422, $e->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $student = Student::find($id);
            if ($student) {
                $student->delete();

                return ResponseHelper::success('student deleted successfully', 200);
            } else {
                return ResponseHelper::error('student deleted successfully', 404);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while deleting student.', 500, $e->getMessage());

        }
    }
}
