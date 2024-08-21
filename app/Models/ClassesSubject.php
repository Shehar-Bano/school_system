<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassesSubject extends Model
{
    use HasFactory;
    public function class()
    {
        return $this->belongsTo(classe::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
