<?php

namespace App\Http\Controllers;

use App\Models\Expence;
use App\Models\InventoryCategory;
use App\Models\InventorySubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenceController extends Controller
{
    public function index(Request $request){

        $query=Expence::with('sub_category','category');
        $categories=InventoryCategory::whereStatus('active')->get();
        $sub_categories=InventorySubCategory::wherestatus('active')->get();
     
        if ($request->has('start_date') && $request->has('end_date') && !empty($request->input('start_date')) && !empty($request->input('end_date'))) {
            $query->whereBetween('date', [$request->input('start_date'), $request->input('end_date')]);
        }
        $categoryId = $request->input('category_id');
        $subCategoryId = $request->input('sub_category_id');
        $query->filterByCategoryAndSubCategory($categoryId, $subCategoryId);
        $expences = $query->paginate(2);
        return view('expence.index',compact('expences','categories','sub_categories'));
    }
    public function create(){
        $categories=InventoryCategory::all();
        $sub_categories=InventorySubCategory::all();
        return view('expence.create',compact('categories','sub_categories'));
      
        }
        public function store(Request $request){
            $validated=$request->validate([
                'category_id'=>'required',
                'sub_category_id'=>'required',
                'amount'=>'required',
                'date'=>'required',
                'description'=>'required|string',
                ]);
                Expence::create($validated);
                return redirect()->back()->with('success','Expence Added Successfully');

            }
            public function edit($id){
                $expence=Expence::find($id);
                $categories=InventoryCategory::all();
                $sub_categories=InventorySubCategory::all();
                return view('expence.edit',compact('expence','categories','sub_categories'));
                }

            public function update(Request $request,$id){
       
                $validated=$request->validate([
                    'category_id'=>'required',
                    'sub_category_id'=>'required',
                    'amount'=>'required',
                    'date'=>'required',
                    'description'=>'required|string',
                    ]);
                   
                    Expence::find($id)->update($validated);
                    return redirect()->back()->with('success','Expence Updated Successfully'); 
                }
                public function delete($id){
                    Expence::find($id)->delete();
                    return redirect()->back()->with('success','Expence Deleted Successfully');
                    }

}
