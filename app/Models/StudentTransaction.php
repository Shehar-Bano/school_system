<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'transaction_id',
        'transaction_type',
        'transaction_date',
        'description',
        'amount',
        'status',
        'due_date',
        'issued_by'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    
    public function issueBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
    public function transaction()
    {
        return $this->belongsTo(TransactionType::class);
    }
      
}
