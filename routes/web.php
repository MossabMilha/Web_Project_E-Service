<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user/{id?}', function ($id ="0") {
    return "Helle user with id $id";
});

