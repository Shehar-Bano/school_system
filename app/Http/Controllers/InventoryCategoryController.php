<?php

namespace App\Http\Controllers;

use App\Models\InventoryCategory;
use Illuminate\Http\Request;

class InventoryCategoryController extends Controller
{
    public function index()
    {
        $categories = InventoryCategory::get();

        return view('inventory-category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',

        ]);
        InventoryCategory::create($validated);

        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function delete($id)
    {
        $category = InventoryCategory::findOrFail($id);
        $category->status = 'deleted';
        $category->save();

        return redirect()->back()->with('success', 'Sub Category Deleted Successfully');

    }

    public function changeStatus($id)
    {
        $category = InventoryCategory::findOrFail($id);
        if ($category->status == 'active') {
            $category->status = 'inactive';
        } else {
            $category->status = 'active';
        }
        $category->save();

        return redirect()->back()->with('success', 'Category Status Changed Successfully');
    }
}
