<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

// Group for Event Routes
Route::prefix('event')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('event.index');
    // Additional routes related to event can go here
});

// Group for Workshop Routes
Route::prefix('workshop')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('workshop.index');
    // Additional routes related to workshops can go here
});

// Group for Product & Spare Parts Routes
Route::prefix('product')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('product.index');
    // Add routes for specific products, categories, or spare parts
});

// Group for Used Car Routes
Route::prefix('used-car')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('used_car.index');
    // Additional used car routes can go here
});

// Group for Profile and Authenticated User Routes
Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('profile.index');
    // Add other profile-related routes if needed
});

// Group for Cart Routes
Route::middleware(['auth'])->prefix('cart')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('cart.index');
    Route::get('/items', [HomeController::class, 'items'])->name('cart.items'); // Example for cart items
    // Additional cart-related routes can go here
});

// Group for Login and Logout Routes (Guest & Auth)
// Route::middleware('guest')->group(function () {
//     Route::get('/login', [Auth\LoginController::class, 'showLoginForm'])->name('login');
// });

// Route::middleware('auth')->group(function () {
//     Route::post('/logout', [Auth\LoginController::class, 'logout'])->name('logout.submit');
// });
