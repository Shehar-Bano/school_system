<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Models\ClassesSubject;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClasseSubjectRequest;

class ClasseSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $limit = $this->getValue($request->input('limit'));

            $classSubject = ClassesSubject::select('id','class_id','subject_id')->paginate($limit);

            if ($classSubject->isEmpty()) {
                return ResponseHelper::error('No classSubject found.', 404); // 404 Not Found
            }

            return ResponseHelper::success($classSubject, 'classSubject retrieved successfully', 200); // 200 OK

        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while fetching classSubject$classSubject.', 500, $e->getMessage()); // 500 Internal Server Error
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClasseSubjectRequest $request)
    {
        try {
            // Get the validated data
            $validated = $request->validated();

            // Create the class
            ClassesSubject::create($validated);

            // Return success response
            return ResponseHelper::successMessage('Class created successfully', 200);

        } catch (\Exception $e) {
            // Handle any exception and return an error response
            return ResponseHelper::error('An error occurred while storing the class.', 500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $class =  ClassesSubject::find($id);
            if ($class) {
                return ResponseHelper::success($class, 200);

            } else {
                return ResponseHelper::error('classSubject not found', 404);

            }
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while fetching classSubject.', 500, $e->getMessage());

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClasseSubjectRequest $request, string $id)
    {
        try {
            // Get the validated data from the request
            $validated = $request->validated();

            // Find the class subject by ID
            $classSubject = ClassesSubject::find($id);

            // Check if the class subject exists
            if (!$classSubject) {
                return ResponseHelper::error('Class subject not found.', 404);
            }

            // Update the class subject with the validated data
            $classSubject->update($validated);

            // Return success response
            return ResponseHelper::successMessage('Class subject updated successfully', 200);

        } catch (\Exception $e) {
            // Handle any exception and return an error response
            return ResponseHelper::error('An error occurred while updating the class subject.', 500, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $classSubject = ClassesSubject::find($id);
            if ($classSubject) {
                $classSubject->delete();

                return ResponseHelper::success('classSubject deleted successfully', 200);
            } else {
                return ResponseHelper::error('classSubject deleted successfully', 404);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while deleting classSubject.', 500, $e->getMessage());

        }
    }
}
