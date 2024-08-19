<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['class_id', 'exam_id', 'section_id', 'start_date', 'end_date'];
    public function class(){
        return $this->belongsTo(Classe::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    public function exam(){
        return $this->belongsTo(Exam::class);
    }
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
    public function datesheet(){
        return $this->belongsTo(DateSheet::class);
    }
}
