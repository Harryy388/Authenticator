<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\http\Controllers\MfaController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', function (Request $request) {
    return $request->user();})->middleware('auth:sanctum');
Route::post('/mfa/verify', [MfaController::class, 'verify'])->middleware('auth:sanctum');
Route::post('/mfa/setup', [MfaController::class, 'setup'])->middleware('auth:sanctum');
Route::post('/mfa/disable', [MfaController::class, 'disable'])->middleware('auth:sanctum');