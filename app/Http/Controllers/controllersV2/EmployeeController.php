<?php

namespace App\Http\Controllers\controllersV2;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;
use Symfony\Component\Console\Input\Input;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $name = $request->input('name');
            $joining_date=$request->input('joining_date');
            $limit = $this->getValue($request->input('limit'));

            $employees = Employee::JoiningDate($joining_date)
                ->searchName(term: $name)->DateBetween($startDate, $endDate)->StatusActive()->paginate($limit)->with('designation');
            
                if ($employees) {
                return ResponseHelper::success($employees, 200);
            } else {
                return ResponseHelper::error('No data found', 404);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while fetching designations.', 500, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        try {
            // The request is already validated at this point
            $validated = $request->validated();
    
            // Handle image upload and store the image path
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $validated['image'] = $imagePath; // Add image path to validated data
            }
    
           
            // Create the employee
            Employee::create($validated);
    
            return ResponseHelper::success('Employee created successfully', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while creating employee.', 500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $employee = Employee::find($id);
            if (!$employee) {
                return ResponseHelper::error('Employee not found', 404);
            }
            return ResponseHelper::success($employee, 200);

        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while fetching employee.', 500, $e->getMessage());
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {
        try {
            $validated = $request->validated();

            if ($request->image) {
                $imagePath = $request->file('image')->store('images', 'public');
                $validated['image'] = $imagePath;
            }
          

            Employee::findOrFail($id)->update($validated);
            return ResponseHelper::success('Employee updated successfully', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while updating employee.', 500, $e->getMessage());
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            if (!$employee) {
                return ResponseHelper::error('Employee not found', 404);
            }
            $employee->delete();
            return ResponseHelper::success('Employee deleted successfully', 200);
        } catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while deleting employee.', 500, $e->getMessage());
        }

    }
}
