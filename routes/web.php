<?php

use App\Http\Controllers\ClasseController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SyllabusController;
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
///////designation
Route::get('/designation', [EmployeeController::class, 'designationView'])->name('designation_view');
Route::post('/designation', [EmployeeController::class, 'designationStore'])->name('designations_store');
Route::delete('/designation/{id}', [EmployeeController::class, 'designationDelete'])->name('designation_delete');
//////Employee
Route::get('employee/view',[EmployeeController::class,'viewEmployee'])->name('employee_view');
Route::get('employee/create',[EmployeeController::class,'createEmployee'])->name('employees_create');
Route::post('employee/store',[EmployeeController::class,'storeEmployee'])->name('employees_store');
Route::get('employee/show/{id}',[EmployeeController::class,'showEmployee'])->name('employees_show');
Route::get('employee/edit/{id}',[EmployeeController::class,'editEmployee'])->name('employees_edit');
Route::post('employee/update/{id}',[EmployeeController::class,'updateEmployee'])->name('employees_update');
Route::delete('employee/delete{id}',[EmployeeController::class,'deleteEmployee'])->name('employees_delete');
////////////subjact
Route::get('/subject/view', [SubjectController::class, 'subjectView'])->name('subject_show');
Route::get('/subject/add', [SubjectController::class, 'addSubjectView'])->name('add_subject');
Route::post('/subject/store', [SubjectController::class, 'subjectStore'])->name('subject_store');
Route::get('/subject/edit/{id}', [SubjectController::class, 'editSubjectView'])->name('edit_subject');
Route::post('/subject/update/{id}', [SubjectController::class, 'subjectUpdate'])->name('subject_update');
Route::delete('/subject/delete/{id}', [SubjectController::class, 'subjectDelete'])->name('subject_delete');
///////////syllabus
Route::get('/syllabus/view', [SyllabusController::class, 'syllabusView'])->name('syllabus_show');
Route::get('/syllabus/add', [SyllabusController::class, 'addSyllabusView'])->name('add_syllabus');
Route::post('/syllabus/store', [SyllabusController::class, 'syllabusStore'])->name('syllabus_store');
Route::get('/syllabus/edit/{id}', [SyllabusController::class, 'editsyllabusView'])->name('edit_syllabus');
Route::post('/syllabus/update/{id}', [SyllabusController::class, 'syllabusUpdate'])->name('syllabus_update');
Route::delete('/syllabus/delete/{id}', [SyllabusController::class, 'syllabusDelete'])->name('syllabus_delete');
Route::get('/download/{file}', [SyllabusController::class, 'download'])->name('file_download');



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
