<?php

namespace App\Http\Controllers\controllersV2;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;


class DesignationController extends Controller
{
   
    public function index(Request $request)
    {
        try {
           
            $searchTerm = $request->input('name');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    

            $limit = $this->getValue($request->input('limit'));
            
            $designations = Designation::SearchName($searchTerm)->DateBetween($startDate,$endDate)->paginate($limit);

            if ($designations->isEmpty()) {
                return ResponseHelper::error('No designations found.', 404); // 404 Not Found
            }

            return ResponseHelper::success($designations, 'Designations retrieved successfully', 200); // 200 OK

        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while fetching designations.', 500, $e->getMessage()); // 500 Internal Server Error
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
       
        $validated = $request->validate([
            'name' => 'required|string|max:50'
        ]);
        if(!$validated){
            return ResponseHelper::error('Validation failed', 422);
        }

        // If validation passes, create the new designation
        Designation::create($validated);

        // Return a success response
        return ResponseHelper::success('Designation created successfully', 200);

    } catch (\Exception $e) {
        // Return an error response if something goes wrong
        return ResponseHelper::error('An error occurred while storing designation.', 500, $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $designation = Designation::find($id);
            if ($designation) {
                return ResponseHelper::success($designation, 200);


            } else {
                return ResponseHelper::error('Designation not found', 404);

            }
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while fetching designation.', 500, $e->getMessage());

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $designation = Designation::find($id);
            if ($designation) {
                $designation->update($request->all());
                return ResponseHelper::success('Designation updated successfully', 200);
            } else {
                return ResponseHelper::error('Designation not found', 404);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while updating designation.', 500, $e->getMessage());

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $designation = Designation::find($id);
            if ($designation) {
                $designation->delete();
                return ResponseHelper::success('designation deleted successfully', 200);
            } else {
                return ResponseHelper::error('designation deleted successfully', 404);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while deleting designation.', 500, $e->getMessage());

        }
    }
}
