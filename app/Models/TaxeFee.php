<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxeFee extends Model
{
    use HasFactory;
    protected $fillable = ['student_id','date','total'];
}
