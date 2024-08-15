<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'gurdian', 'admissiondate', 'dob', 'gender', 'religion',
        'email', 'phone', 'address', 'class_id', 'section_id', 'group',
        'registration', 'username', 'password', 'image', 'note'
    ];

    public function classe(){
        return $this->belongsTo(Classe::class);
    }
    public function section(){
        return $this->belongsTo(Section::class);
    }
    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}
