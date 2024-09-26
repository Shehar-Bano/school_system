<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\Filterable;

class Employee extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable ,Notifiable,Filterable; // Use Authenticatable trait to satisfy the contract
    protected $fillable=[
        'name',
        'gender',
        'date_of_birth',
        'designation_id',
        'email',
        'phone',
        'address',
        'password',
        'status',
        'salary',
        'joining_date',
        'image',
        'religion'

    ];
    public function scopeJoiningDate($query,$joining_date)
    {
        if($joining_date !=''){
        return $query->where('joining_date',$joining_date);
        }
        return $query;
    }
    // Relationships
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function class()
    {
        return $this->hasMany(Classe::class);
    }

    public function section()
    {
        return $this->hasMany(Section::class);
    }

    public function subjects()
    {
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
