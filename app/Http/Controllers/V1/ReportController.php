<?php

namespace App\Http\Controllers\V1;

use App\Http\Resources\ReportResource;
use App\Models\Expence;
use App\Models\TaxeFee;
use App\Models\StudentFee;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expences = Expence::select('category_id')
        ->selectRaw('SUM(amount) as total_amount')
        ->groupBy('category_id')
        ->get();
       $studentFee = StudentFee::sum('total');
       $taxe= TaxeFee::sum('total');
       $categorizedIncome = [
        'student_fees' => [
            'category' => 'Student Fees',
            'total' => $studentFee,
        ],
        'taxes' => [
            'category' => 'Taxes',
            'total' => $taxe,
        ],
    ];
    $totalIncome = $studentFee + $taxe;
    // Optionally, include the total income in the categorized array
    $categorizedIncome['total_income'] = [
        'category' => 'Total Income',
        'total' => $totalIncome,
    ];
    return ResponseHelper::success([
        'expenses' => ReportResource::collection($expences),
        'categorized_income' => $categorizedIncome,
    ], 200);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
