<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    // Other model methods and properties

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function class()
    {
        return $this->belongsTo(classe::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
