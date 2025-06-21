<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CreateProductController;
use App\Http\Controllers\Admin\UpdateProductController;
use App\Http\Controllers\Admin\BlogController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/orders', [OrderController::class, 'order'])->name('admin.order');
    Route::get('/admin/orders/search', [OrderController::class, 'search'])->name('admin.orders.search');
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::get('/admin/products', [ProductController::class, 'product'])->name('admin.product');
    Route::get('/admin/products/search', [ProductController::class, 'search'])->name('admin.products.search');
    Route::get('/admin/users', [UserController::class, 'user'])->name('admin.user');
    Route::get('/admin/users/search', [UserController::class, 'search'])->name('admin.users.search');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/admins', [AdminController::class, 'admin'])->name('admin.admins');
    Route::get('/admin/admins/{id}/edit', [AdminController::class, 'edit'])->name('admin.admins.edit');
    Route::put('/admin/admins/{id}', [AdminController::class, 'update'])->name('admin.admins.update');
    Route::delete('/admin/admins/{id}', [AdminController::class, 'destroy'])->name('admin.admins.destroy');
    Route::prefix('admin/products')->controller(CreateProductController::class)->group(function () {
        Route::get('/create', 'createProduct')->name('admin.products.create.form');
        Route::post('/create', 'formProduct')->name('admin.products.create');
    });
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/admin/products/{id}/edit', [UpdateProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [UpdateProductController::class, 'update'])->name('admin.products.update');

    // Blog quản trị
    Route::prefix('blog')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('admin.blog.index');
        Route::get('/create', [BlogController::class, 'create'])->name('admin.blog.create');
        Route::post('/store', [BlogController::class, 'store'])->name('admin.blog.store');
        Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('admin.blog.edit');
        Route::post('/update/{id}', [BlogController::class, 'update'])->name('admin.blog.update');
        Route::delete('/delete/{id}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');
    });

    Route::post('/admin/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
    Route::get('/admin/orders/{id}/edit', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/admin/orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
});