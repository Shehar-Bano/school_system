<?php

use App\Http\Controllers\controllersV2\DesignationController;
use App\Http\Controllers\controllersV2\EmployeeController;
use App\Http\Controllers\controllersV2\SubjectController;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('designations', DesignationController::class);
Route::apiResource('employees',EmployeeController::class);
Route::apiResource('subjects',SubjectController::class);
