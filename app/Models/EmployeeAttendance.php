<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'date', 'attendance','status'];

    public function scopeWhereEmployee($query,$employee_id){
        if($employee_id){
            return $query->where('employee_id', $employee_id);
        }
        return $query;
    }
    public function scopeWhereDesignation($query,$designation_id){
        if ($designation_id) {
            return $query->whereHas('employee', function ($q) use ($designation_id) {
                $q->where('designation_id', $designation_id);
            });
        }
        return $query;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
