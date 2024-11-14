<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\SupportCenterController;
use App\Http\Controllers\SuperAdmin\AuthController as SuperAdminAuthController;
use App\Http\Controllers\UsedCarController;
use App\Http\Controllers\ProductSparePartController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');

// Auth routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login-send');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register-send');

Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot-password-send');
Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password-send');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// UsedCar
Route::get('used-car', [UsedCarController::class, 'index'])->name('used-car');
Route::get('used car', [UsedCarController::class, 'detail'])->name('usedcar.detail');

// Product & SparePart
Route::get('ProductSparePart', [ProductSparePartController::class, 'index'])->name('ProductSparePart');

// Contact Routes
Route::get('contact', [PageController::class, 'contact'])->name('contact');
Route::post('contact', [MessageController::class, 'sendContactMessage'])->name('message-send');

Route::get('about', [PageController::class, 'about'])->name('about');
Route::get('faqs', [PageController::class, 'faqs'])->name('faqs');
Route::get('terms', [PageController::class, 'terms'])->name('terms');
Route::get('support-center', [PageController::class, 'supportCenter'])->name('support-center');
Route::get('detail', [PageController::class, 'detail'])->name('detail');
Route::get('login-admin', [SuperAdminAuthController::class, 'showLogin'])->name('login-admin');
Route::post('login-admin', [SuperAdminAuthController::class, 'login'])->name('login-admin-send');
Route::get('superadmin', [PageController::class, 'superAdmin'])->name('superadmin');
Route::get('support-center-category', [SupportCenterController::class, 'category'])->name('support-center-category');
Route::get('cart', [PaymentController::class, 'index'])->name('cart');


// Profile route
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::get('/profile/address', [ProfileController::class, 'showAddress'])->name('profile.address');
Route::get('/profile/address/create', [ProfileController::class, 'addAddress'])->name('profile.address.create');
Route::post('/profile/address/store', [ProfileController::class, 'storeAddress'])->name('address.store');
Route::get('profile/setting', [ProfileController::class, 'showSetting'])->name('profile.setting');
Route::post('/profile/reset-password', [ProfileController::class, 'resetPassword'])->name('profile.resetPassword');

// Event route
Route::get('event', [EventController::class, 'show'])->name('event.show');
Route::get('event/detail', [EventController::class, 'detail'])->name('event.detail');


// Workshop route
Route::get('workshop', [WorkshopController::class, 'show'])->name('workshop.show');
Route::get('workshop/detail', [WorkshopController::class, 'detail'])->name('workshop.detail');
