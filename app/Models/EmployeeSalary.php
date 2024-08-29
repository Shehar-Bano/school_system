<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'base_salary',
        'date',
        'bonus',
        'deduction',
        'gross_salary',
        'net_salary'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function financeRecodes()
    {
        return $this->belongsTo(Finance_recode::class);
    }
    
}
