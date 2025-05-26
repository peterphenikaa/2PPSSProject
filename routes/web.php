<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('layouts.layouts');
});

Route::get('/login',
    [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']
)->name('login');
Route::post('/login',
    [App\Http\Controllers\Auth\LoginController::class, 'checkLogin']
)->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/register',
    [App\Http\Controllers\Auth\RegiseterController::class, 'showRegistrationForm']
)->name('register');
Route::post('/register',
    [App\Http\Controllers\Auth\RegiseterController::class, 'checkRegister']
)->name('register.post');

Route::get('/forgot-password',
    [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm']
)->name('password.request');