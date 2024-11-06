<?php

use App\Http\Controllers\AuthController as PelangganAuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductSparePartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\AuthController as SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\SupportCenterController;
use App\Http\Controllers\UsedCarController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');

// Auth routes
Route::prefix('pelanggan')->group(function () {
    Route::get('login', [PelangganAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [PelangganAuthController::class, 'login'])->name('login-send');
    Route::get('register', [PelangganAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [PelangganAuthController::class, 'register'])->name('register-send');
    Route::get('forgot-password', [PelangganAuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('forgot-password', [PelangganAuthController::class, 'sendResetLink'])->name('forgot-password-send');
    Route::get('reset-password/{token}', [PelangganAuthController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('reset-password', [PelangganAuthController::class, 'resetPassword'])->name('reset-password-send');
    Route::post('logout', [PelangganAuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth:pelanggan')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
});

Route::prefix('superadmin')->group(function () {
    Route::get('login', [SuperAdminAuthController::class, 'showLogin'])->name('login-admin');
    Route::post('login', [SuperAdminAuthController::class, 'login'])->name('login-admin-send');
    Route::post('logout/admin', [SuperAdminAuthController::class, 'logout'])->name('logout-admin');
});

// UsedCar
Route::get('used-car', [UsedCarController::class, 'index'])->name('used-car');
Route::get('used car', [UsedCarController::class, 'detail'])->name('usedcar.detail');

// Product & SparePart
Route::get('ProductSparePart', [ProductSparePartController::class, 'index'])->name('ProductSparePart');
Route::get('/detail-ProductSparePart', [ProductSparePartController::class, 'detail'])->name('Detail-ProductSparePart');

// Contact Routes
Route::get('contact', [PageController::class, 'contact'])->name('contact');
Route::post('contact', [MessageController::class, 'sendContactMessage'])->name('message-send');

Route::get('about', [PageController::class, 'about'])->name('about');
Route::get('faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('terms', [PageController::class, 'terms'])->name('terms');
Route::get('support-center', [PageController::class, 'supportCenter'])->name('support-center');
Route::get('detail', [PageController::class, 'detail'])->name('detail');
Route::get('career', [PageController::class, 'career'])->name('career');
Route::get('superadmin', [PageController::class, 'superAdmin'])->name('superadmin');
Route::get('support-center-category', [SupportCenterController::class, 'category'])->name('support-center-category');

// Profile route
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::get('/profile/address', [ProfileController::class, 'showAddress'])->name('profile.address');
Route::get('/profile/address/create', [ProfileController::class, 'addAddress'])->name('profile.address.create');
Route::post('/profile/address/store', [ProfileController::class, 'storeAddress'])->name('address.store');
Route::get('profile/setting', [ProfileController::class, 'showSetting'])->name('profile.setting');
Route::post('/profile/reset-password', [ProfileController::class, 'resetPassword'])->name('profile.resetPassword');
Route::get('profile/used-car', [UsedCarController::class, 'showUsedCar'])->name('profile-used-car');
Route::get('profile/used-car/create', [UsedCarController::class, 'create'])->name('used-car-create');
Route::post('profile/used-car/store', [UsedCarController::class, 'store'])->name('used-car-store');
Route::get('/profile/address/edit/{id_alamat_pengiriman}', [ProfileController::class, 'editAddress'])->name('address.edit');
Route::post('/profile/address/update/{id_alamat_pengiriman}', [ProfileController::class, 'updateAddress'])->name('address.update');
Route::delete('/profile/address/delete/{id_alamat_pengiriman}', [ProfileController::class, 'delete'])->name('address.delete');

// Event route
Route::get('event', [EventController::class, 'show'])->name('event.show');
Route::get('event/detail', [EventController::class, 'detail'])->name('event.detail');

// Workshop route
Route::get('workshop', [WorkshopController::class, 'show'])->name('workshop.show');
Route::get('workshop/detail', [WorkshopController::class, 'detail'])->name('workshop.detail');
