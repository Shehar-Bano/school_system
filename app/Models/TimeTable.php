<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;
    protected $fillable=[
        'day',
        'start_time',
        'end_time',
        'class_id',
        'section_id',
        'subject_id',
        'teacher_id',
        'class_id',
        'room',


    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function class()
    {
        return $this->belongsTo(classe::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function teacher(){
        return $this->belongsTo(Employee::class);
    }
}
