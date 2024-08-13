<?php

use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Models\Exam;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
//////Employee
Route::get('employee/view',[EmployeeController::class,'viewEmployee'])->name('employee_view');
Route::get('employee/create',[EmployeeController::class,'createEmployee'])->name('employees_create');
Route::post('employee/store',[EmployeeController::class,'storeEmployee'])->name('employees_store');
Route::get('employee/show/{id}',[EmployeeController::class,'showEmployee'])->name('employees_show');
Route::get('employee/edit/{id}',[EmployeeController::class,'editEmployee'])->name('employees_edit');
Route::post('employee/update/{id}',[EmployeeController::class,'updateEmployee'])->name('employees_update');
Route::delete('employee/delete{id}',[EmployeeController::class,'deleteEmployee'])->name('employees_delete');
////////////exam
Route::get('/exam',[ExamController::class,'index'])->name('exam');
Route::post('/exam',[ExamController::class,'store'])->name('store');
Route::get('/exam/list',[ExamController::class,'list'])->name('exam-list');
Route::delete('/exam/del/{id}',[ExamController::class,'del'])->name('exam_delete');
Route::get('/exam/edit/{id}',[ExamController::class,'edit'])->name('edit');
Route::post('/exam/update/{id}',[ExamController::class,'update'])->name('update');
///////////////class
Route::get('/class',[ClasseController::class,'index'])->name('class');
Route::post('/class',[ClasseController::class,'store'])->name('store');
Route::get('/class/list',[ClasseController::class,'list'])->name('class-list');
Route::delete('/class/del/{id}',[ClasseController::class,'del'])->name('class_delete');
Route::get('/class/edit/{id}',[ClasseController::class,'edit'])->name('edit');
Route::post('/class/update/{id}',[ClasseController::class,'update'])->name('update');
/////////////////section
Route::get('/section',[SectionController::class,'index'])->name('section');
Route::post('/section',[SectionController::class,'store'])->name('store');
Route::get('/section/list',[SectionController::class,'list'])->name('section-list');
Route::delete('/section/del/{id}',[SectionController::class,'del'])->name('section_delete');
Route::get('/section/edit/{id}',[SectionController::class,'edit'])->name('edit');
Route::post('/section/update/{id}',[SectionController::class,'update'])->name('update');
