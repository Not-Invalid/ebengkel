<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsedCarController;
use App\Http\Controllers\ProductSparePartController;
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
Route::get('usedCar', [UsedCarController::class, 'index'])->name('usedCar');
Route::get('usedCar/detail', [UsedCarController::class, 'detail'])->name('usedcar.detail');

// Product & SparePart
Route::get('ProductSparePart', [ProductSparePartController::class, 'index'])->name('ProductSparePart');

// Contact Routes
Route::get('contact', [PageController::class, 'contact'])->name('contact');
Route::post('/send-message', [MessageController::class, 'sendContactMessage'])->name('message-send');

Route::get('about', [PageController::class, 'about'])->name('about');
Route::get('faqs', [PageController::class, 'faqs'])->name('faqs');

// Profile route
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
