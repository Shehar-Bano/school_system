<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProfileController;
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
Route::get('/exam',[ExamController::class,'index'])->name('exam');
Route::post('/exam',[ExamController::class,'store'])->name('store');
Route::get('/exam/list',[ExamController::class,'list'])->name('exam-list');
Route::delete('/exam/del/{id}',[ExamController::class,'del'])->name('exam_delete');
Route::get('/exam/edit/{id}',[ExamController::class,'edit'])->name('edit');
Route::post('/exam/update/{id}',[ExamController::class,'update'])->name('update');
