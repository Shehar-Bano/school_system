<?php

namespace App\Http\Controllers\V1;

use App\Models\Expence;
use App\Models\TaxeFee;
use App\Models\StudentFee;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch filters from the request
        $startDate = $request->input('startdate');
        $endDate = $request->input('enddate');
        $class = $request->input('class');
        $section = $request->input('section');

        // Filter expenses based on startdate and enddate
        $expensesQuery = Expence::select('category_id')
            ->selectRaw('SUM(amount) as total_amount')
            ->groupBy('category_id');

        if ($startDate && $endDate) {
            $expensesQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        $expenses = $expensesQuery->get();

        // Filter student fees and taxes based on the filters
        $studentFeeQuery = StudentFee::query();
        $taxeQuery = TaxeFee::query();

        // Apply date filter
        if ($startDate && $endDate) {
            $studentFeeQuery->whereBetween('created_at', [$startDate, $endDate]);
            $taxeQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Apply class and section filters if provided
        if ($class) {
            $studentFeeQuery->where('class_id', $class);
        }

        if ($section) {
            $studentFeeQuery->where('section_id', $section);
        }

        // Calculate total income
        $studentFee = $studentFeeQuery->sum('total');
        $taxe = $taxeQuery->sum('total');

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
            'expenses' => ReportResource::collection($expenses),
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
