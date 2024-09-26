<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finance_recode extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'transaction_date',
        'transaction_type',
        'description',
        'amount',
        'status',
        'due_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
