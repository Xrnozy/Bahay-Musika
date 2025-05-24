<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/home', function () {
    return view('home'); // home.blade.php
});

Route::get('/contacts', function () {
    return view('contacts');
});

Route::get('/donation', function () {
    return view('donation');
});

Route::get('/events', function () {
    return view('events');
});

Route::get('/news', function () {
    return view('news');
});
Route::get('/testing', function () {
    return view('testing');
});

Route::post('/register', [UserController::class, 'register']);