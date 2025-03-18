<?php


use App\Http\Controllers\LoginProcesse;
use App\Http\Controllers\AdminController;
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

Route::delete('/Admin/UserManagement/assignment/{id}', [AdminController::class, 'DeleteAssignment'])->name('UserManagement.deleteAssignment');
Route::post('/Admin/UserManagement/assignment', [AdminController::class, 'AddAssignment'])->name('UserManagement.addAssignment');






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



