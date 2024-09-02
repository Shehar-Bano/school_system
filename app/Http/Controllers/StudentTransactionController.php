<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentTransaction;
use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentTransactionController extends Controller
{
    public function index(Request $request)
    {
       
        $transactionCategories = TransactionType::get();
        $transactions = StudentTransaction::with(['student', 'issueBy']);
    
        if ($request->has('start_date') && $request->has('end_date')) {
            $transactions = $transactions->whereBetween('transaction_date', [$request->input('start_date'), $request->input('end_date')]);
        }
    
        if ($request->has('category_id')) {
            $transactions = $transactions->where('transaction_id', $request->input('category_id'));
        }
    
        $transactions = $transactions->get();
    
        return view('student-transaction.index', compact('transactions',  'transactionCategories'));
    }
        public function create()
        {
            $classes=classe::get();
            $sections=Section::get();
            $students=Student::with('class')->get();
            $types=TransactionType::get();
            return view('student-transaction.create',compact('students','classes','sections','types'));
      }
      public function store(Request $request)
      {
        $validated=$request->validate([
            'amount'=>'required|numeric',
            'student_id'=>'required|exists:students,id',
            'transaction_type'=>'required',
            'class'=>'required|exists:classes,id',
            'section'=>'required|exists:sections,id',
            'transaction_id'=>'required',
            'description'=>'required',
            'transaction_date'=>'required',
            'due_date'=>'required'
            ]);
            $user=Auth::user();
            $userid=$user->id;
        

            StudentTransaction::create([
                'amount'=>$validated['amount'],
                'student_id'=>$validated['student_id'],
                'transaction_id'=>$validated['transaction_id'],
                'transaction_type'=>$validated['transaction_type'],
                'description'=>$validated['description'],
                'transaction_date'=>$validated['transaction_date'],
                'due_date'=>$validated['due_date'],
                'issued_by'=>$userid,
                'status'=>'active'
            ]);
            return redirect()->back()->with('success','Transaction created successfully');
            }
    public function delete($id){
        $transaction=StudentTransaction::find($id);
        $transaction->delete();
        return redirect()->back()->with('success','Transaction deleted successfully');

    }
    public function edit($id)
    {
            $transaction=StudentTransaction::findOrFail($id);
            $classes=classe::get();
            $sections=Section::get();
            $students=Student::with('class')->get();
            $types=TransactionType::get();
            return view('student-transaction.edit',compact('transaction','students','classes','sections','types'));
    }
    public function update(Request $request,$id)
    {
        $validated=$request->validate([
            'amount'=>'required|numeric',
            'student_id'=>'required|exists:students,id',
            'transaction_type'=>'required',
            'class'=>'required|exists:classes,id',
            'section'=>'required|exists:sections,id',
            'transaction_id'=>'required',
            'description'=>'required',
            'transaction_date'=>'required',
            'due_date'=>'required'
            ]);
            $user=Auth::user();
            $userid=$user->id;
            $transaction=StudentTransaction::find($id);
            $transaction->update([
               'amount'=>$validated['amount'],
                'student_id'=>$validated['student_id'],
                'transaction_id'=>$validated['transaction_id'],
                'transaction_type'=>$validated['transaction_type'],
                'description'=>$validated['description'],
                'transaction_date'=>$validated['transaction_date'],
                'due_date'=>$validated['due_date'],
                'issued_by'=>$userid,
                'status'=>'active'
            ]);
            return redirect()->back()->with('success','Transaction Updated successfully');
            }


            

}
