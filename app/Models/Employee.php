<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function class(){
        return $this->hasMany(Classe::class);
    }
    public function section(){
        return $this->hasMany(Section::class);
    }
    public function subjects(){
        return $this->hasMany(Subject::class);
        }
    public function attendance()
    {
        return $this->belongsTo(EmployeeAttendance::class);
    }
    public function financeRecode()
    {
        return $this->belongsTo(Finance_recode::class);
    }
    public function financeRecords()
    {
        return $this->hasMany(Finance_recode::class);
    }
}
