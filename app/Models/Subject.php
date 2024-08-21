<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
 public function teacher()
 {
     return $this->belongsTo(Employee::class);
 }
 public function class(){
    return $this->belongsTo(Classe::class);
 }
 public function assignments()
 {
     return $this->hasMany(Assignment::class);
 }
 public function classSunject()
 {
     return $this->hasMany(ClassesSubject::class);
 }
 public function timetable()
 {
     return $this->belongsTo(TimeTable::class);
 }
}
