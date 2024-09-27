<?php


use App\Http\Controllers\V1\TimeTableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ClasseController;
use App\Http\Controllers\V1\StudentController;
use App\Http\Controllers\V1\SubjectController;
use App\Http\Controllers\V1\EmployeeController;
use App\Http\Controllers\V1\DesignationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('designations', DesignationController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('classes', ClasseController::class);
Route::apiResource('employees', EmployeeController::class);
Route::apiResource('subjects', SubjectController::class);
Route::apiResource('time_tables', TimeTableController::class);
