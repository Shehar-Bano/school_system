<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    public function result(){
        return $this->hasMany(Result::class);
    }
    public function examschedule(){
        return $this->hasMany(ExamSchedule::class);
    }

}
