<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable ,Notifiable; // Use Authenticatable trait to satisfy the contract

    // Relationships
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

    public function financeRecordBonus()
    {
        return $this->hasMany(Finance_recode::class);
    }

    public function financeRecordDeduction()
    {
        return $this->hasMany(Finance_recode::class);
    }
}
