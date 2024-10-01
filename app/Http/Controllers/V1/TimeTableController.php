<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TimeTableRequest;
use App\Http\Resources\TimeTableResource;
use App\Models\TimeTable;
use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $class = $request->input('class_id');
            $section = $request->input('section_id');
            $teacher = $request->input('teacher_id');
            $subject = $request->input('subject_id');
            $status= $request->input('status');
            $limit = $this->getValue($request->input('limit'));
            $columns = [
                'id',
                'day',
                'start_time',
                'end_time',
                'class_id',
                'section_id',
                'subject_id',
                'teacher_id',
                'class_id',
                'slot_status'
            ];

            $data = TimeTable::with(['subject', 'class', 'section', 'teacher'])
                ->select($columns)->whereClass($class)->whereSubject($subject)
                ->whereTeacher($teacher)->whereSection($section)->showStatus($status)
                ->paginate($limit);
                
                if(!$data){
                    return ResponseHelper::error( 'No data found',404);
                }

                return ResponseHelper::success(TimeTableResource::collection($data), 200);

        }
        catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while deleting employee.', 500, $e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TimeTableRequest $request)
    {
        try {
            
            $validated = $request->validated();
            $teacherId = $validated['teacher_id'];
            $day = $validated['day'];
    
           
            $existingSchedule = TimeTable::existingSchedule($teacherId, $day, $request);
    
          
            if ($existingSchedule) {
                return ResponseHelper::error('Time slot already booked for the selected time.', 400);
            }
    
            TimeTable::create($validated);
    
            return ResponseHelper::successMessage('TimeTable added successfully!', 200);
    
        } catch (\Exception $e) {
            // Catch any exception and return an error response
            return ResponseHelper::error('An error occurred while creating timetable.', 500, $e->getMessage());
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TimeTableRequest $request, string $id)
    {
        try {
            
            $validated = $request->validated();
      
            
            $teacherId = $validated['teacher_id'];
            $day = $validated['day'];
    
            
            $existingSchedule = TimeTable::where('id', '!=', $id)
                ->existingSchedule($teacherId, $day, $request);
    
            
            if ($existingSchedule) {
                return ResponseHelper::error('Time slot already booked for the selected time.', 400);
            }
    
            $timeTable = TimeTable::find($id);
            $timeTable->update($validated);
    
            return ResponseHelper::successMessage('TimeTable updated successfully!', 200);
    
        } catch (\Exception $e) {
            
            return ResponseHelper::error('An error occurred while updating timetable.', 500, $e->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $timeTable = TimeTable::find($id);
            if (!$timeTable) {
                return ResponseHelper::error('TimeTable not found.', 404);
            }
            $timeTable->delete();
            return ResponseHelper::successMessage('TimeTable deleted successfully!', 200);

        }
        catch (\Exception $e) {
            return ResponseHelper::error('An error occurred while deleting timetable.', 500, $e->getMessage());
        }

    }


}

