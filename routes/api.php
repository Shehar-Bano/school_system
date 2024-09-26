<?php

use App\Http\Controllers\controllersV2\DesignationController;
use App\Http\Controllers\V1\ClasseController;
use App\Http\Controllers\V1\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('designations', DesignationController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('classes', ClasseController::class);
