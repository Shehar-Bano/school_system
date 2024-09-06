<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use App\Models\InventorySubCategory;
use Illuminate\Http\Request;

class InventorySubCategoryController extends Controller
{
    public function index(){
        $categories=InventoryCategory::get();
        $subcategories=InventorySubCategory::with('category')->get();
        return view('inventory-subcategory.index',compact('subcategories','categories'));
    }
    public function store(Request $request){
        $validated=$request->validate([
            'name'=>'required',
            'category_id'=>'required',
            
        ]);
        InventorySubCategory::create($validated); 
        return redirect()->back()->with('success','Sub Category Added Successfully');
    
    }

    public function delete($id){
        $category=InventorySubCategory::findOrFail($id);
        $category->status='deleted';
        $category->save();
        return redirect()->back()->with('success','Sub Category Deleted Successfully');


    }
    public function changeStatus($id){
        $category=InventorySubCategory::findOrFail($id);
        if($category->status=='active'){
            $category->status='inactive';
            }else{
                $category->status='active';
                }
                $category->save();
                return redirect()->back()->with('success','Sub Category Status Changed Successfully');

    }
}
