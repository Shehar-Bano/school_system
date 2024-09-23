<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxe extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_taxes',
        'admission_fee',
        'other_activity',
        'lunch',
        'library_tax',
    ];
}
