<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.layouts');
});
Route::get('/login',
    [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']
)->name('login');
Route::get('/register',
    [App\Http\Controllers\Auth\RegiseterController::class, 'showRegistrationForm']
)->name('register');
Route::get('/forgot-password',
    [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm']
)->name('password.request');