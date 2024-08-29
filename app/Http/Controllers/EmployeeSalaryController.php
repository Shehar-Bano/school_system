<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Finance_recode;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class EmployeeSalaryController extends Controller
{
    public function index(Request $request)
    {
        // Get the date filters from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $employee= $request->input('employee_id');

    // Get all employee salaries for the given date range
        // Base query
        $query = EmployeeSalary::with('employee.financeRecords');
    
        // Apply date filters if provided
        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('date', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        if ($employee) {
           $query->where('employee_id',$employee);
        }
    
       
        $salaries = $query->get();
    
        
        $employees = Employee::select('id', 'name')->get();
    
        // Perform calculations
        $calculatedSalaries = $salaries->map(function ($salary) {
            $employee = $salary->employee;
            $bonus = $employee->financeRecords
                ->whereIn('transaction_type', ['Performance Bonus', 'Festival Bonus', 'Duty Reward', 'Paper Checking Reward'])
                ->sum('amount'); 
            $deduction = $employee->financeRecords
                ->whereIn('transaction_type', ['Late Penalty', 'Absentance Penalty', 'Loan Repayment'])
                ->sum('amount');
            $gross_salary = $employee->salary + $bonus;
            $net_salary = $gross_salary - $deduction;
    
            return [
                'id' => $salary->id,
                'employee_id' => $salary->employee_id,
                'employee_name' => $employee->name,
                'date' => \Carbon\Carbon::parse($salary->date)->format('M, Y'),
                'base_salary' => $employee->salary,
                'bonus' => $bonus,
                'deduction' => $deduction,
                'gross_salary' => $gross_salary,
                'net_salary' => $net_salary,
                'status' => $salary->status,
            ];
        });
    
        return view('salary.index', compact('calculatedSalaries', 'employees','employee', 'startDate', 'endDate'));
    }
    
    

    public function store()
    {
        $employees = Employee::all();
        $salaryData = [];
    
        $employees->each(function ($employee) use (&$salaryData) {
            $salaryData[] = [
                'employee_id' => $employee->id,
                'date' => now(),
            ];
        });
    
        $currentDate = now()->format('Y-m-d'); // Format the current date as Y-m-d
    
        $salarydate = EmployeeSalary::whereDate('date', $currentDate)->first(); // Use whereDate to compare only the date
        
    
        if ($salarydate) {
            return redirect()->back()->with('error', 'Salary already added for this month!');
        }
    
        // Insert employee_id and date only
        EmployeeSalary::insert($salaryData);
    
        return redirect()->back()->with('success', 'Salaries added successfully!');
    }
    

  public function pay($id){
    $employee=EmployeeSalary::findOrFail($id);
    if($employee->status=='paid'){
        return redirect()->back()->with('error','Salary already paid');
    }
   $employee->status='paid';
   $employee->save();
   return redirect()->back()->with('success', 'Salary paid successfully!');


  }

  

  public function PDFview($id)
  {
      $employee = EmployeeSalary::with('employee')->find($id);
      $transctions = Finance_recode::select('employee_id', 'transaction_type', 'amount')->get();
    
      $bonus = $employee->employee->financeRecords->whereIn('transaction_type', ['Performance Bonus', 'Festival Bonus', 'Duty Reward', 'Paper Checking Reward'])
          ->sum('amount'); 
      $deduction = $employee->employee->financeRecords->whereIn('transaction_type', ['Late Penalty', 'Absentance Penalty', 'Loan Repayment'])
          ->sum('amount');
      
      $gross_salary = $employee->employee->salary + $bonus;
      $net_salary = $gross_salary - $deduction;
      
      $pdf = Pdf::loadView('salary.printPDF', compact('employee', 'gross_salary', 'net_salary', 'deduction', 'bonus', 'transctions'))
      ->setPaper('A4', 'portrait')
      ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
  
      return $pdf->download('salary_slip.pdf');  // To download
      // return $pdf->stream();  // To display in the browser
  }
  
  
  
  
}
