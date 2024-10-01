<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// app/Http/Controllers/ExamReportController.php

use App\Reports\ExamReportFactory;

class ExamReportController extends Controller
{
    public function generateReport(Request $request)
    {
       try{
         // Validate incoming request data
         $request->validate([
            'report_type' => 'required|string',
            'exam_id' => 'required|integer',
            'class_id' => 'sometimes|integer',
            'student_id' => 'sometimes|integer',
            'teacher_id' => 'sometimes|integer', // New validation rule for teacher reports
        ]);

        // Use the factory to create the appropriate report
        $report = ExamReportFactory::create($request->report_type, $request->all());
       
        // Generate the report
        $data = $report->generate();
        if(!$data){
            return ResponseHelper::error('Failed to generate report', 500);
            
        }

       return ResponseHelper::success($data,200);
    }
    catch(\Exception $e){
        return ResponseHelper::error($e->getMessage(),500);
        }
       }
}
