<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $name = $user->name;

        return view('view-file.main', compact('name'));
    }
}
