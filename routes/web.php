<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OAuthController;


Route::get('/auth/github', [OAuthController::class, 'redirect']);
Route::get('/auth/github/callback', [OAuthController::class, 'callback']);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/mfa-setup', function () {
    return view('mfa-setup');
});


