<?php


use App\Http\Controllers\LoginProcesse;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginProcesse::class, 'showLoginForm'])->name('login.form');  // Show the login page
Route::post('/login', [LoginProcesse::class, 'login'])->name('login');  // Handle login





Route::get('/user/{id?}', function ($id ="0") {
    return view('user', ['id' => $id]);
});
Route::get('/home', function () {
    return view('home');
});


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
