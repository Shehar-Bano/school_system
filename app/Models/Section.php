<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    public function class(){
        return $this->belongsTo(Classe::class);
    }
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
