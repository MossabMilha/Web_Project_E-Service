<?php


use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\LoginProcesse;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\TeachingStaffController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginProcesse::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginProcesse::class, 'login'])->name('login');



Route::get('/Admin/UserManagement', [AdminController::class, 'UserManagement'])->name('UserManagement');
Route::get('/Admin/UserManagement', [AdminController::class, 'search'])->name('UserManagement.search');
Route::get('/Admin/UserManagement/user/{id}', [AdminController::class, 'UserInformation'])->name('UserManagement.user');
Route::put('/Admin/UserManagement/user/{id}/edit', [AdminController::class, 'EditUser'])->name('UserManagement.editUser');
Route::get('/Admin/UserManagement/AddUser', [AdminController::class, 'AddUser'])->name('UserManagement.adduser');
Route::post('/Admin/UserManagement/AddUser', [AdminController::class, 'AddUserDb'])->name('UserManagement.adduserDB');
Route::delete('/Admin/UserManagement/DeleteUser/{id}', [AdminController::class, 'DeleteUser'])->name('UserManagement.deleteUser');
Route::delete('/Admin/UserManagement/assignment/{id}', [AdminController::class, 'DeleteAssignment'])->name('UserManagement.deleteAssignment');
Route::post('/Admin/UserManagement/assignment', [AdminController::class, 'AddAssignment'])->name('UserManagement.addAssignment');


Route::get('/DepartmentHead/TeachingUnits', [DepartmentHeadController::class, 'index'])->name('TeachingUnits');
Route::get('/DepartmentHead/TeachingUnits/search', [DepartmentHeadController::class, 'search'])->name('TeachingUnits.search');
Route::get('/DepartmentHead/TeachingUnits/{id}', [DepartmentHeadController::class, 'show'])->name('TeachingUnits.unit');
Route::get('/DepartmentHead/TeachingUnits/unit/{id}/assign', [DepartmentHeadController::class, 'assign'])->name('TeachingUnits.assign');
Route::post('/DepartmentHead/TeachingUnits/unit/{id}/assign', [DepartmentHeadController::class, 'assignDB'])->name('TeachingUnits.assignDB');
Route::get('/DepartmentHead/TeachingUnits/unit/{id}/reassign', [DepartmentHeadController::class, 'reassign'])->name('TeachingUnits.reassign');

Route::get('/DepartmentHead/professors/list',[DepartmentHeadController::class, 'showProfessors'])->name('Professors.list');
Route::get('/DepartmentHead/professor/{id}/profile',[ProfessorController::class, 'show'])->name('Professor.profile');
Route::get('/DepartmentHead/professors/{id}/assignUnits',[ProfessorController::class, 'assignUnits'])->name('Professor.assignUnits');
Route::post('/DepartmentHead/professors/{id}/assignUnits',[ProfessorController::class, 'assignUnitsDB'])->name('Professor.assignUnitsDB');
Route::delete('/DepartmentHead/professors/list/{unit_id}/{professor_id}', [ProfessorController::class, 'removeAssign'])->name('Professor.removeAssign');


Route::get('/Coordinator/{id}/teachingUnits', [CoordinatorController::class, 'teachingUnits'])->name('Coordinator.teachingUnits');
Route::post('/Coordinator/{id}/teachingUnits/AddUnit', [CoordinatorController::class, 'AddUnit'])->name('Coordinator.AddUnit');
Route::post('/Coordinator/{id}/teachingUnits/EditUnit', [CoordinatorController::class, 'EdtUnit'])->name('Coordinator.EditUnit');






Route::get('/TeachingStuff/{id}/Assignments', [TeachingStaffController::class, 'ShowAssignments'])->name('TeachingStuff.Assignments');






Route::get('/user/{id?}', function ($id ="0") {
    return view('user', ['id' => $id]);
});
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/courses', function () {
    return view('courses');
});
Route::get('/re-enrollment', function () {
    return view('re-enrollment');
});
Route::get('/requests', function () {
    return view('requests');
});
Route::get('/grades', function () {
    return view('grades');
});
Route::get('/prof-details', function () {
    return view('prof-details');
});



