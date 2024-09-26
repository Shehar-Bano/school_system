<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Employee extends Model implements AuthenticatableContract
{
    use Authenticatable, Filterable ,HasFactory,Notifiable; // Use Authenticatable trait to satisfy the contract

    protected $fillable = [
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
        'religion',

    ];

    public function scopeJoiningDate($query, $startDate, $endDate)
    {

        if (($startDate && $endDate) && $startDate != '' && $endDate != '') {

            return $query->whereBetween('joining_date', [$startDate, $endDate]);
        }

        return $query;
    }

    // Relationships
    public function designation()
    {
        return $this->belongsTo(Designation::class)->select('id', 'name');
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
