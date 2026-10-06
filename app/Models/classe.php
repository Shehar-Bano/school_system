<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tution_fee',
        'note',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function section()
    {
        return $this->hasMany(Section::class, 'classe_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'classe_id');
    }

    public function student()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'classes_subjects', 'class_id', 'subject_id');
    }

    public function classsubject()
    {
        return $this->belongsToMany(Subject::class, 'classes_subjects', 'class_id', 'subject_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_id');
    }

    public function examschedule()
    {
        return $this->hasMany(ExamSchedule::class, 'class_id');
    }

    public function examSchedules()
    {
        return $this->hasMany(ExamSchedule::class, 'class_id');
    }

    public function syllabi()
    {
        return $this->hasMany(Syllabus::class, 'class_id');
    }

    public function timetables()
    {
        return $this->hasMany(TimeTable::class, 'class_id');
    }
}
