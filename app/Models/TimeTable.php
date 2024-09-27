<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'class_id',
        'section_id',
        'subject_id',
        'teacher_id',
        'class_id',
      

    ];
    public function scopeExistingSchedule($query, $teacherId, $day, $request)
    {
        return $query->where('teacher_id', $teacherId)
            ->where('slot_status', 'allocated')
            ->where('day', $day)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])

                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_time', '<=', $request->start_time)
                              ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->first();
    }
    
   public function scopeShowStatus($query, $statuses)
{
    if (is_array($statuses)) {
        // If multiple statuses are provided as an array, use whereIn
        return $query->whereIn('slot_status', $statuses);
    }

    // If only a single status is provided, use where
    return $query->where('slot_status', $statuses);
}

    public function scopeWhereClass($query,$classId){
        if($classId){
            $exists=classe::where('id',$classId)->exists();
            if($exists){
               return $query->where('class_id',$classId);
            }
        }
        return $query;
       
    }
    public function scopeWhereSubject($query,$subjectId){
        if($subjectId){
            $exists=Subject::where('id',$subjectId)->exists();
            if($exists){
               return $query->where('subject_id',$subjectId);
            }
        }
        return $query;
       
    }
    public function scopeWhereSection($query,$sectionId){
        if($sectionId){
            $exists=Section::where('id',$sectionId)->exists();
            if($exists){
               return $query->where('section_id',$sectionId);
            }
        }
        return $query;
       
    }
    public function scopeWhereTeacher($query,$teacherId){
        if($teacherId){
            $exists=Employee::where('id',$teacherId)->exists();
            if($exists){
               return $query->where('teacher_id',$teacherId);
            }
        }
        return $query;
       
    }

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

    public function teacher()
    {
        return $this->belongsTo(Employee::class);
    }
}
