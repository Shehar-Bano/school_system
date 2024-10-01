<?php


namespace App\Repositories;

interface EmployeeAttendanceRepositoryInterface
{

    public function all($limit,$employee_id, $designation_id);
    /**
     * Get attendance record by ID
     *
     * @param int $id
     */
    public function find($id);

  
    /**
     * Mark attendance for a student
     *
     * @param array $data
     */
    public function markAttendance(array $validated);

}
