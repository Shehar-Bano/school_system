<?php
// app/Repositories/AttendanceRepository.php

namespace App\Repositories;

use App\Models\EmployeeAttendance;

class EmployeeAttendanceRepository implements EmployeeAttendanceRepositoryInterface
{
    protected $model;

    public function __construct(EmployeeAttendance $attendance)
    {
        $this->model = $attendance;
    }

    public function all($limit,$employee_id,$designation_id)
    {
        return $this->model->with('employee')->
        whereEmployee($employee_id)->whereDesignation($designation_id)
        ->paginate($limit);
        
    }

    public function find($id)
    {
        $columns=[
            'id',
            'employee_id',
            'date',
            'status'
        ];
        return $this->model->select( $columns)->with('employee')->where('employee_id',$id)->get();  // Retrieve a specific attendance record by ID
    }

    public function markAttendance(array$validated)
    {
        return $this->model->create($validated);  // Mark attendance
    }

}
