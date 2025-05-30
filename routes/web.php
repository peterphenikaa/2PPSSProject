<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegiseterController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Product;

Route::get('/', function () {
    return view('layouts.layouts');
});

Route::get('/login',
    [LoginController::class, 'showLoginForm']
)->name('login');
Route::post('/login',
    [LoginController::class, 'checkLogin']
)->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/register',
    [RegiseterController::class, 'showRegistrationForm']
)->name('register');
Route::post('/register',
    [RegiseterController::class, 'checkRegister']
)->name('register.post');

Route::get('/forgot-password',
    [ForgotPasswordController::class, 'showLinkRequestForm']
)->name('password.request');

Route::post('/forgot-password',
    [ForgotPasswordController::class, 'checkEmail']
)->name('password.checkemail');

Route::get('/reset-password',
    [ForgotPasswordController::class, 'showResetPassword']
)->name('reset.password');

Route::post('/reset-password',
    [ForgotPasswordController::class, 'resetPassword']
)->name('password.update');

Route::middleware('auth')->get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
Route::middleware('auth')->get('/admin/orders', [OrderController::class, 'order'])->name('admin.order');
Route::middleware('auth')->get('/admin/products', [ProductController::class, 'product'])->name('admin.product');
Route::middleware('auth')->get('/admin/users', [UserController::class, 'user'])->name('admin.user');


