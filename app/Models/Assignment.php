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
        'title',
        'description',
        'deadline',
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
}
