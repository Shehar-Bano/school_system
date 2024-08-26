<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classe extends Model
{
    use HasFactory;
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    public function section(){
        return $this->hasMany(Section::class);
    }
    public function student(){
        return $this->hasMany(Student::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    public function examschedule(){
        return $this->hasMany(ExamSchedule::class);
    }
}
