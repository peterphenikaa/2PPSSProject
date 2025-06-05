<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegiseterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProductController;

// Route public và auth
Route::get('/', function () {
    return view('layouts.layouts');
});

Route::get(
    '/login',
    [LoginController::class, 'showLoginForm']
)->name('login');
Route::post(
    '/login',
    [LoginController::class, 'checkLogin']
)->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get(
    '/register',
    [RegiseterController::class, 'showRegistrationForm']
)->name('register');
Route::post(
    '/register',
    [RegiseterController::class, 'checkRegister']
)->name('register.post');

Route::get(
    '/forgot-password',
    [ForgotPasswordController::class, 'showLinkRequestForm']
)->name('password.request');

Route::post(
    '/forgot-password',
    [ForgotPasswordController::class, 'checkEmail']
)->name('password.checkemail');

Route::get(
    '/reset-password',
    [ForgotPasswordController::class, 'showResetPassword']
)->name('reset.password');

Route::post(
    '/reset-password',
    [ForgotPasswordController::class, 'resetPassword']
)->name('password.update');

// Route sản phẩm cho khách
Route::get('/products/{filter}', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/', [ProductController::class, 'homepageProducts'])->name('home');