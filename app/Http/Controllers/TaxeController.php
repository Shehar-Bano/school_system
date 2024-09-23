<?php

namespace App\Http\Controllers;

use App\Models\Taxe;
use Illuminate\Http\Request;

class TaxeController extends Controller
{
    public function create()
    {
        return view('taxe.create');
    }

    // Store a new tax entry in the database
    public function store(Request $request)
    {
        $request->validate([
            'bus_taxes' => 'required|string',
            'admission_fee' => 'required|string',
            'other_activity' => 'required|string',
            'lunch' => 'required|string',
            'library_tax' => 'required|string',
        ]);

        $tax = new Taxe();
        $tax->bus_taxes = $request->bus_taxes;
        $tax->admission_fee = $request->admission_fee;
        $tax->other_activity = $request->other_activity;
        $tax->lunch = $request->lunch;
        $tax->library_tax = $request->library_tax;
        $tax->save();

        return redirect()->back()->with('success', 'Tax record added successfully');
    }
}
