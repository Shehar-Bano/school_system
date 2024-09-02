<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use Illuminate\Http\Request;

class TransactionTypeController extends Controller
{
    
    public function index()
    {
        $transactions=TransactionType::get();
        return view('transaction-type.index',compact('transactions'));
    }
    public function store(Request $request){
       $validated= $request->validate([
            'name'=>'required',
            'description'=>'required'
            ]);
            TransactionType::create($validated);
            return redirect()->back()->with('success','Transaction Type Added Successfully');
    }
    // public function edit($id){
    //     $transaction=TransactionType::find($id);
    //     return view('transaction-type.edit',compact('transaction'));
    //     }

        public function delete($id){
            $transaction=TransactionType::find($id);
            $transaction->delete();
            return redirect()->back()->with('success','Transaction Type Deleted Successfully');
        }

}
