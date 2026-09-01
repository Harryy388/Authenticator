<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/mfa-setup', function () {
    return view('mfa-setup');
});