<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Student extends Authenticatable
{
    use  Notifiable;

    protected $fillable = [
        'name', 'gurdian', 'admissiondate', 'dob', 'gender', 'religion',
        'email', 'phone', 'address', 'class_id', 'section_id', 'group',
        'registration', 'password', 'image', 'note', 'tution_fee','username',
    ];

    protected $hidden = ['password'];

    // For the student guard
    protected $guard = 'student';

    public function class(){
        return $this->belongsTo(Classe::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }


    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function results() {
        return $this->hasMany(Result::class);
    }
    public function exam(){
        return $this->belongsTo(Exam::class);
    }
   public function transaction()
   {
       return $this->hasMany(StudentTransaction::class);
   }

}
