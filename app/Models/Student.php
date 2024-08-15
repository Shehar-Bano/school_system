<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public function classe(){
        return $this->belongsTo(Classe::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }
}
