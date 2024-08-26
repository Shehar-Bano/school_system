<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateSheet extends Model
{
    use HasFactory;

    public function exam_schedule(){
        return $this->hasMany(ExamSchedule::class);
    }
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
