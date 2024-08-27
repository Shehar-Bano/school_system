<?php

use App\Models\Exam;
use App\Models\ExamSchedule;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SyllabusController;

use App\Http\Controllers\TimeTableController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ExamScheduleController;

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
Route::get('/download_file/{file}',[SyllabusController::class, 'downloadFile'])->name('download_file');
Route::get('/syllabus/detail/{id}',[SyllabusController::class, 'syllabusDetail'])->name('syllabus_detail');

/////assignment
Route::get('/assignment/view', [AssignmentController::class, 'assignmentView'])->name('assignment_show');
Route::get('/assignment/add', [AssignmentController::class, 'addAssignmentView'])->name('add_assignment');
Route::post('/assignment/store', [AssignmentController::class, 'assignmentStore'])->name('assignments_store');
Route::get('/assignment/edit/{id}', [AssignmentController::class, 'editAssignmentView'])->name('edit_assinment');
Route::post('/assignment/update/{id}', [AssignmentController::class, 'assignmentUpdate'])->name('assignments_update');
Route::delete('/assignment/delete/{id}', [AssignmentController::class, 'assignmentDelete'])->name('assignment_delete');
Route::get('/assignment/detail/{id}',[AssignmentController::class, 'assignmetDetail'])->name('assignmet_detail');
//////////timeTable
Route::get('/timeTable', [TimeTableController::class, 'timeTableActions'])->name('timeTable');
Route::get('/timeTable/class', [TimeTableController::class, 'timeTableView'])->name('timeTable_show');
Route::get('/timeTable/teacher', [TimeTableController::class, 'timeTableViewTeacher'])->name('teacher_timeTable_show');
Route::get('/timeTable/add', [TimeTableController::class, 'addTimeTableView'])->name('timeTable_create');
Route::post('/timeTable/store', [TimeTableController::class, 'timeTableStore'])->name('timeTable_store');
Route::get('/timeTable/edit/{id}', [TimeTableController::class, 'editTimeTableView'])->name('timetable_edit');
Route::put('/timeTable/update/{id}', [TimeTableController::class, 'timeTableUpdate'])->name('timeTable_update');
Route::get('/timeTable/delete/{id}', [TimeTableController::class, 'timeTableDelete'])->name('timetable_delete');
Route::get('/timetable/freeSlot/{id}', [TimeTableController::class, 'timetableFreeSlot'])->name('timetable_freeSlot');
Route::get('/timetable/occupySlot/{id}', [TimeTableController::class,'timetableOccupySlot'])->name('timetable_occupySlot');
//////////////Employees Attendece
Route::get('/attendance/employee/view', [AttendanceController::class, 'employeeAttendanceView'])->name('employee_attendence');
Route::get('/attendance/employee/add', [AttendanceController::class, 'addAttendanceView'])->name('add_attendance');
Route::get('/attendance/employee/show/{id}', [AttendanceController::class, 'showEmployeeAttendance'])->name('show_employee_attendace');
Route::post('/attendance/employee/store', [AttendanceController::class, 'employeeAttendanceStore'])->name('attendance_store');

/////////////Student Attendace
Route::get('/attendance/student/', [AttendanceController::class, 'attendanceClass'])->name('students_class');
Route::get('/attendance/student/class/choice', [AttendanceController::class, 'attendanceClass'])->name('students_class_select');


Route::get('/attendance/student/view', [AttendanceController::class, 'studentAttendanceView'])->name('students_attendence');
Route::get('/attendance/student/add', [AttendanceController::class, 'addStudentAttendanceView'])->name('add_student_attendance');
Route::get('/attendance/student/show/{id}', [AttendanceController::class, 'showStudentAttendance'])->name('show_student_attendace');

Route::post('/attendance/student/store', [AttendanceController::class, 'studentAttendanceStore'])->name("student_attendance_store");

Route::get('/attendance/class/view', [AttendanceController::class, 'classAttendanceView'])->name('select_attendance_class');









////////////exam
Route::get('/exam',[ExamController::class,'index'])->name('exam');
Route::post('/exam',[ExamController::class,'store'])->name('store');
Route::get('/exam/list',[ExamController::class,'list'])->name('exam-list');
Route::delete('/exam/del/{id}',[ExamController::class,'del'])->name('exam_delete');
Route::get('/exam/edit/{id}',[ExamController::class,'edit'])->name('exam-edit');
Route::post('/exam/update/{id}',[ExamController::class,'update'])->name('exam-update');
///////////////class
Route::get('/class',[ClasseController::class,'index'])->name('class');
Route::post('/class',[ClasseController::class,'store'])->name('store');
Route::get('/class/list',[ClasseController::class,'list'])->name('class-list');
Route::delete('/class/del/{id}',[ClasseController::class,'del'])->name('class_delete');
Route::get('/class/edit/{id}',[ClasseController::class,'edit'])->name('class-edit');
Route::post('/class/update/{id}',[ClasseController::class,'update'])->name('class-update');
/////////////////section
Route::get('/section',[SectionController::class,'index'])->name('section');
Route::post('/section',[SectionController::class,'store'])->name('store');
Route::get('/section/list',[SectionController::class,'list'])->name('section-list');
Route::delete('/section/del/{id}',[SectionController::class,'del'])->name('section_delete');
Route::get('/section/edit/{id}',[SectionController::class,'edit'])->name('section-edit');
Route::post('/section/update/{id}',[SectionController::class,'update'])->name('section-update');
/////////////////////student
Route::get('/student',[StudentController::class,'index'])->name('student');

Route::post('/student',[StudentController::class,'store'])->name('store');
Route::get('/student/list',[StudentController::class,'list'])->name('student-list');
Route::delete('/student/del/{id}',[StudentController::class,'del'])->name('student_delete');
Route::get('/student/edit/{id}',[StudentController::class,'edit'])->name('student-edit');
Route::post('/student/update/{id}',[StudentController::class,'update'])->name('student-update');
////////////////////exam-schedule
Route::get('/exam/schedule',[ExamScheduleController::class,'index'])->name('exam-schedule');
Route::post('/exam/schedule',[ExamScheduleController::class,'store'])->name('exam_schedule_store');
Route::get('/exam/schedule/list',[ExamScheduleController::class,'list'])->name('exam-schedule-list');
Route::get('/exam/schedule/list/{id}',[ExamScheduleController::class,'resultPrint'])->name('exam-result');

Route::delete('/exam/schedule/del/{id}',[ExamScheduleController::class,'del'])->name('exam-schedule_delete');
Route::get('/exam/schedule/edit/{id}',[ExamScheduleController::class,'edit'])->name('exam-schedule-edit');
Route::post('/exam/schedule/update/{id}',[ExamScheduleController::class,'updateschedule'])->name('exam-schedule-update');
Route::get('/exam/schedule/datesheet/{id}',[ExamScheduleController::class,'datesheetview'])->name('date-sheet');

Route::post('/exam/schedule/datesheet/store/{id}',[ExamScheduleController::class,'datesheet'])->name('datesheet_store');
Route::get('/exam/schedule/datesheet/list/{id}/',[ExamScheduleController::class,'datesheetlist'])->name('date-sheet-list');
Route::delete('/exam/schedule/datesheet/del/{id}',[ExamScheduleController::class,'datedel'])->name('exam-schedule-date_delete');
Route::get('/exam/schedule/datesheet/edit/{id}',[ExamScheduleController::class,'dateedit'])->name('exam-schedule-date-edit');
Route::post('/exam/schedule/datesheet/{id}', [ExamScheduleController::class, 'dateupdateschedule'])->name('exam.schedule.datesheet.update');
///////////////////////result
Route::get('/result',[ResultController::class,'index'])->name('result');
Route::get('/result/add',[ResultController::class,'add'])->name('result-add');
Route::post('/result/store',[ResultController::class,'store'])->name('result-store');
Route::get('/result/list',[ResultController::class,'list'])->name('result-list');
Route::get('/result/list/view/{id}',[ResultController::class,'view'])->name('result-view');
Route::get('/result/card',[ResultController::class,'showResultCard'])->name('result.card');
Route::get('/notfound',[ResultController::class,'notFound'])->name('not_Found');

///////////////////////////fees
Route::get('/fees',[FeeController::class,'index'])->name('fee');
Route::get('/fees/add',[FeeController::class,'add'])->name('fee-add');
Route::post('/fees/store',[FeeController::class,'store'])->name('student-fee-store');
Route::get('/fees/list',[FeeController::class,'viewStudentFee'])->name('student-fee-list');
Route::get('/fees/reciept/{id}',[FeeController::class,'reciept'])->name('fee-reciept');
Route::get('/receipt/download/{studentId}', [FeeController::class, 'downloadReceipt'])->name('receipt.download');

