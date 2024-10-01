<?php


use App\Http\Controllers\V1\ExamReportController;
use App\Http\Controllers\V1\TimeTableController;
use Illuminate\Http\Request;
use App\Models\ClassesSubject;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ClasseController;
use App\Http\Controllers\V1\StudentController;
use App\Http\Controllers\V1\SubjectController;
use App\Http\Controllers\V1\EmployeeController;
use App\Http\Controllers\V1\DesignationController;
use App\Http\Controllers\V1\ClasseSubjectController;
use App\Http\Controllers\V1\EmployeeAttendanceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('designations', DesignationController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('classes', ClasseController::class);
Route::apiResource('employees', EmployeeController::class);
Route::apiResource('subjects', SubjectController::class);
Route::apiResource('classes_subjects', ClasseSubjectController::class);
Route::apiResource('time_tables', TimeTableController::class);
Route::apiResource('employee_attendances',EmployeeAttendanceController::class);
Route::post('exam-report',[ExamReportController::class,'generateReport']);
