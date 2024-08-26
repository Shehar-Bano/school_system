<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
        public function class(){
            return $this->belongsTo(Classe::class);
        }
        public function section(){
            return $this->belongsTo(Section::class);
        }
        public function exam(){
            return $this->belongsTo(exam::class);
        }
        public function student(){
            return $this->belongsTo(Student::class);
        }
        public function subject(){
            return $this->belongsTo(Subject::class);
        }

}
