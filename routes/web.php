<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OAuthController;


Route::get('/auth/github', [OAuthController::class, 'redirect']);
Route::get('/auth/github/callback', [OAuthController::class, 'callback']);

Route::get('/', function () {
    return view('welcome');
});


Route::get('/mfa-setup', function () {
    return view('mfa-setup');
});