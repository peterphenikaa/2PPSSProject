<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegiseterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Shop\BlogController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminStoreController;
use App\Http\Controllers\Auth\SocialController;

// Route public và auth
// Route trang chủ: truyền newProducts cho layout
Route::get('/', [ProductController::class, 'homepageProducts'])->name('home');

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
Route::get('/products', function() {
    return redirect('/products/new-arrivals');
});
Route::get('/products/{filter}', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/brands/{brand}', [ProductController::class, 'brandFilter'])->name('products.brand');

// Route trang blog
Route::get('/blogs', [BlogController::class, 'index'])->name('shop.blog.index');
Route::get('/blogs/{slug}', [BlogController::class, 'show'])->name('shop.blog.show');

// Route trang giỏ hàng
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

// Giỏ hàng
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', [CartController::class, 'checkoutForm'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'checkoutSubmit'])->name('cart.checkout.submit');

Route::get('/checkout/momo-qr/{order}', [CartController::class, 'showMomoQR'])->name('cart.momo_qr');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Admin CRUD Product
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    // Admin CRUD Blog
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index');
    Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/blogs', [AdminBlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/blogs/{id}/edit', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/blogs/{id}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/blogs/{id}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy');

    // Admin CRUD Store
    Route::get('/stores', [AdminStoreController::class, 'index'])->name('admin.stores.index');
    Route::get('/stores/create', [AdminStoreController::class, 'create'])->name('admin.stores.create');
    Route::post('/stores', [AdminStoreController::class, 'store'])->name('admin.stores.store');
    Route::get('/stores/{id}/edit', [AdminStoreController::class, 'edit'])->name('admin.stores.edit');
    Route::put('/stores/{id}', [AdminStoreController::class, 'update'])->name('admin.stores.update');
    Route::delete('/stores/{id}', [AdminStoreController::class, 'destroy'])->name('admin.stores.destroy');
});

Route::get('auth/{provider}', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialController::class, 'callback'])->name('social.callback');
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
