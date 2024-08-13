<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function class(){
        return $this->hasMany(Classe::class);
    }
    public function section(){
        return $this->hasMany(Section::class);
    }
}
