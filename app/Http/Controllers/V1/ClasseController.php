<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClasseRequest;
use App\Models\classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $limit = $this->getValue($request->input('limit'));

            $classes = classe::paginate($limit);

            if ($classes->isEmpty()) {
                return ResponseHelper::error('No classes found.', 404); // 404 Not Found
            }

            return ResponseHelper::success($classes, 'classes retrieved successfully', 200); // 200 OK

        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while fetching students.', 500, $e->getMessage()); // 500 Internal Server Error
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClasseRequest $request)
    {
        try {
            // Get the validated data
            $validated = $request->validated();

            // Create the class
            classe::create($validated);

            // Return success response
            return ResponseHelper::success('Class created successfully', 200);

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
            $class = classe::find($id);
            if ($class) {
                return ResponseHelper::success($class, 200);

            } else {
                return ResponseHelper::error('class not found', 404);

            }
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while fetching class.', 500, $e->getMessage());

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClasseRequest $request, string $id)
    {
        try {
            // Validate the request data
            $validated = $request->validated();

            // Find the class by ID, or fail with a 404
            $class = classe::findOrFail($id);

            // Update the class with the validated data
            $class->update($validated);

            // Return a success response
            return ResponseHelper::success('Class updated successfully', 200);

        } catch (\Exception $e) {
            // Handle any exception and return an error response
            return ResponseHelper::error('An error occurred while updating the class.', 500, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $class = classe::find($id);
            if ($class) {
                $class->delete();

                return ResponseHelper::success('class deleted successfully', 200);
            } else {
                return ResponseHelper::error('class deleted successfully', 404);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while deleting class.', 500, $e->getMessage());

        }
    }
}
