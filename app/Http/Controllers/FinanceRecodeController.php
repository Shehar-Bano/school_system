<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Finance_recode;
use Illuminate\Http\Request;

class FinanceRecodeController extends Controller
{
    public function index(Request $request){
        $employees=Employee::get();
        $query=Finance_recode::with('employee');
        if($request->has('employee_id')){
            $query->where('employee_id','like','%'.$request->input('employee_id').'%');
        }
        if($request->has('transaction_type')){
            $query->where('transaction_type','like','%'.$request->input('transaction_type').'%');
        }
 
 if ($request->has('start_date') && $request->has('end_date') &&
 $request->input('start_date') != '' && $request->input('end_date') != ''){
            $query->whereBetween('transaction_date',[$request->input('start_date'),$request->input('end_date')]);
         
        }
        $recodes=$query->get();
        return view('finance.recode',compact('recodes','employees'));
    }

    public function addFinanceRecordView(){
        $employees=Employee::get();
        return view('finance.add',compact('employees'));
    }
    public function storeFinanceRecord(Request $request){

        $validated = $request->validate([
          
            'employee_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
             'transaction_type'=>'required',
             'transaction_date' => 'required',
              'due_date'=>'required|date'
          
        ]);
       
        Finance_recode::create($validated);
        return redirect()->back()->with('success','Finance record added successfully');
    }


    public function deleteFinanceRecord($id){
       $recodeId= Finance_recode::findOrFail($id);
        $recodeId->status='deleted';
        $recodeId->save();
        return redirect()->back()->with('success','Finance record deleted successfully');
        
        
    }

    public function editFinanceRecordView($id){
        $employees=Employee::get();
        $recode=Finance_recode::with('employee')->findOrFail($id);
        return view('finance.edit',compact('recode','employees'));
        

    
    }
    public function updateFinanceRecord(Request $request,$id){
        $validated = $request->validate([
          
            'employee_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
             'transaction_type'=>'required',
             'transaction_date' => 'required',
             'due_date'=>'required|date'
              
          
        ]);
       $recode= Finance_recode::findOrFail($id);
       $recode->update($validated);
        return redirect()->back()->with('success','Finance record updated successfully');



}
}