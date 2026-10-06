<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'type', // optional or mandatory
        'pass_marks',
        'final_marks',
        'sub_code', // subject code
    ];

    public function teacher()
    {
        return $this->belongsTo(Employee::class);
    }

    public function class()
    {
        return $this->belongsTo(classe::class);
    }

    public function classes()
    {
        return $this->belongsToMany(classe::class, 'classes_subjects', 'subject_id', 'class_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function classSubject()
    {
        return $this->hasMany(ClassesSubject::class, 'subject_id');
    }

    public function timetables()
    {
        return $this->hasMany(TimeTable::class, 'subject_id');
    }

    public function timetable()
    {
        return $this->hasMany(TimeTable::class, 'subject_id');
    }

    public function dateSheets()
    {
        return $this->hasMany(DateSheet::class, 'subject_id');
    }

    public function result()
    {
        return $this->hasMany(Result::class, 'subject_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'subject_id');
    }
}
