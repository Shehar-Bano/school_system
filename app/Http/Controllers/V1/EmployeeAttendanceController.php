<?php

namespace App\Http\Controllers\V1;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeAttendanceResource;
use App\Repositories\EmployeeAttendanceRepositoryInterface;
use Illuminate\Http\Request;

class EmployeeAttendanceController extends Controller
{
    protected $employeeAttendance;
    public function __construct(EmployeeAttendanceRepositoryInterface $employeeAttendanceRepository){
        $this->employeeAttendance=$employeeAttendanceRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employee_id=$request->input('employee_id');
        $designation_id=$request->input('designation_id');
        $limit=$this->getValue($request->input('limit'));
      $attendance=  $this->employeeAttendance->all($limit,$employee_id, $designation_id);
      if(!$attendance){
        return ResponseHelper::error('No data found',404);
      }
      $customPaginationData = [
        'List Of Attendance Recodes' => EmployeeAttendanceResource::collection($attendance)->response()->getData(true)['data'], // The actual paginated data
        'pagination' => [
            'current_page' => $attendance->currentPage(),
           'total_recode' => $attendance->total(),
            'limit' => $attendance->perPage(),
        ],
    ];
      return ResponseHelper::success($customPaginationData,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       try{
        $validated=$request->validate([
            'employee_id'=>'required',
            'status'=> 'required',
            'date'=>'required',
        ]);

        $this->employeeAttendance->markAttendance( $validated);
        return ResponseHelper::successMessage('Attendance Added Successfully');
       }
       catch(\Exception $e){
        return ResponseHelper::error($e->getMessage(),500);
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $data=$this->employeeAttendance->find($id);
            if(!$data){
                return ResponseHelper::error('No data found',404);
            }
            return ResponseHelper::success(EmployeeAttendanceResource::collection($data),200);
            
        }
        catch(\Exception $e){
            return ResponseHelper::error($e->getMessage(),500);
            }
    }
      
   
}
