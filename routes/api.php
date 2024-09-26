<?php

use App\Http\Controllers\V1\DesignationController;
use App\Http\Controllers\V1\EmployeeController;
use App\Http\Controllers\V1\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('designations', DesignationController::class);
Route::apiResource('employees', EmployeeController::class);
Route::apiResource('subjects', SubjectController::class);
