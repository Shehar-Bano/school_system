<?php

namespace App\Http\Controllers;

use App\Models\Expence;
use App\Models\Student;
use App\Models\StudentFee;

class BalanceSheetController extends Controller
{
    public function index()
    {
        // Get Student Fees (Credits)
        $fees = StudentFee::all()->map(function ($fee) {
            return [
                'date' => $fee->date,
                'description' => 'Student Fee', // Add your description here
                'amount' => $fee->total,
                'type' => 'credit', // Treat as credit
            ];
        });

        // Get Expenses (Debits)
        $expenses = Expence::all()->map(function ($expense) {
            return [
                'date' => $expense->date,
                'description' => $expense->description ?? 'Expense', // Add your description here
                'amount' => $expense->amount,
                'type' => 'debit', // Treat as debit
            ];
        });

        // Combine both arrays and sort by date
        $entries = $fees->merge($expenses)->sortBy('date');

        // Calculate totals
        $totalDebit = $entries->where('type', 'debit')->sum('amount');
        $totalCredit = $entries->where('type', 'credit')->sum('amount');

        return view('balanceSheet.index', compact('entries', 'totalDebit', 'totalCredit'));
    }
}
