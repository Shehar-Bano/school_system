<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'section_id',
        'subject_id',
        'teacher_id',
        'title',
        'description',
        'deadline',
        'total_marks',
        'uploader',
        'assignment',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function class()
    {
        return $this->belongsTo(classe::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Employee::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'assignment_id');
    }

    /**
     * Get real-time assignment tracking stats
     */
    public function getTrackingStats()
    {
        $totalStudents = Student::where('class_id', $this->class_id)
            ->where('section_id', $this->section_id)
            ->count();

        $submittedCount = $this->submissions()->count();
        $pendingCount = max(0, $totalStudents - $submittedCount);
        $percentage = $totalStudents > 0 ? round(($submittedCount / $totalStudents) * 100) : 0;

        $isDeadlinePassed = now()->isAfter(\Carbon\Carbon::parse($this->deadline)->endOfDay());

        return [
            'total_students' => $totalStudents,
            'submitted_count' => $submittedCount,
            'pending_count' => $pendingCount,
            'percentage' => $percentage,
            'is_deadline_passed' => $isDeadlinePassed,
        ];
    }
}
