<?php

use App\Http\Controllers\AuthController as PelangganAuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\ProductSparePartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\ProfileController as SuperAdminProfileController;
use App\Http\Controllers\SuperAdmin\AuthController as SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\EventController as SuperAdminEventController;
use App\Http\Controllers\SuperAdmin\MessagesController as SuperAdminMessagesController;
use App\Http\Controllers\SuperAdmin\MerkMobilController;
use App\Http\Controllers\SuperAdmin\ProductSparepartController as SuperAdminProductSparePartController;
use App\Http\Controllers\SuperAdmin\SupportCenterController;
use App\Http\Controllers\SuperAdmin\WorkshopController as SuperAdminWorkshopController;
use App\Http\Controllers\UsedCarController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\ServiceController;
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
    Route::get('/', [SuperAdminAuthController::class, 'showLogin'])->name('login-admin');
    Route::post('login', [SuperAdminAuthController::class, 'login'])->name('login-admin-send');
    Route::post('logout/admin', [SuperAdminAuthController::class, 'logout'])->name('logout-admin');

    Route::get('dashboard', [DashboardController::class, 'superAdmin'])->name('superadmin');

    Route::get('event-data', [SuperAdminEventController::class, 'index'])->name('event-data');
    Route::get('event-data/create', [SuperAdminEventController::class, 'create'])->name('event-create');
    Route::post('event-data/store', [SuperAdminEventController::class, 'store'])->name('event-store');
    Route::get('event-data/edit/{id}', [SuperAdminEventController::class, 'edit'])->name('event-edit');
    Route::post('event-data/update/{id}', [SuperAdminEventController::class, 'update'])->name('event-update');
    Route::delete('event-data/delete/{id}',[SuperAdminEventController::class, 'delete'])->name('event-delete');
    Route::get('/event/{eventId}/daftar-peserta', [SuperAdminEventController::class, 'showPesertaEvent'])->name('event-peserta');

    Route::get('merk-mobil', [MerkMobilController::class, 'index'])->name('merk-mobil');
    Route::get('merk-mobil/create', [MerkMobilController::class, 'create'])->name('merk-mobil-create');
    Route::post('merk-mobil/store', [MerkMobilController::class, 'store'])->name('merk-mobil-send');
    Route::get('merk-mobil/edit/{id}', [MerkMobilController::class, 'edit'])->name('merk-mobil-edit');
    Route::post('merk-mobil/update/{id}', [MerkMobilController::class, 'update'])->name('merk-mobil-update');
    Route::delete('merk-mobil/delete/{id}', [MerkMobilController::class, 'delete'])->name('merk-mobil-delete');

    Route::get('inbox', [SuperAdminMessagesController::class,'index'])->name('inbox');

    Route::get('workshop', [SuperAdminWorkshopController::class, 'index'])->name('workshop-data');

    Route::get('profile', [SuperAdminProfileController::class, 'index'])->name('profile');
});

// UsedCar
Route::get('used-car', [UsedCarController::class, 'index'])->name('used-car');
Route::get('used-car/{id_mobil}', [UsedCarController::class, 'detail'])->name('usedcar.detail');

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
Route::get('/support-center/{category}', [PageController::class, 'detail'])->name('support-center.detail');
Route::get('career', [PageController::class, 'career'])->name('career');
Route::get('support-center-category', [SupportCenterController::class, 'category'])->name('support-center-category');
Route::get('support-center-category/create', [SupportCenterController::class, 'createCategory'])->name('support-center-category-create');
Route::post('support-center-category/store', [SupportCenterController::class, 'storeCategory'])->name('support-center-category-send');
Route::get('support-center-category/edit/{id}', [SupportCenterController::class, 'editCategory'])->name('support-center-category-edit');
Route::post('support-center-category/update{id}', [SupportCenterController::class, 'updateCategory'])->name('support-center-category-update');
Route::delete('/support-center/delete/{id}', [SupportCenterController::class, 'deleteCategory'])->name('support-center-category-delete');
Route::get('support-center-info', [SupportCenterController::class, 'showInfo'])->name('support-center-info');
Route::get('support-center-info/create', [SupportCenterController::class, 'createInfo'])->name('support-center-info-create');
Route::post('support-center-info/store', [SupportCenterController::class, 'storeInfo'])->name('support-center-info-send');
Route::get('support-center-info/edit/{id}', [SupportCenterController::class, 'editInfo'])->name('support-center-info-edit');
Route::put('support-center-info/update/{id}', [SupportCenterController::class, 'updateInfo'])->name('support-center-info-update');
Route::delete('support-center-info/delete/{id}', [SupportCenterController::class, 'deleteInfo'])->name('support-center-info-delete');

Route::get('product-sparepart-category', [SuperAdminProductSparePartController::class, 'showCategory'])->name('product-sparepart-category');
Route::get('product-sparepart-category/create', [SuperAdminProductSparePartController::class, 'createCategory'])->name('product-sparepart-create');
Route::post('product-sparepart-category/store', [SuperAdminProductSparePartController::class, 'storeCategory'])->name('product-sparepart-send');
Route::get('product-sparepart-category/edit/{id_kategori_spare_part}', [SuperAdminProductSparePartController::class, 'editCategory'])->name('product-sparepart-edit');
Route::post('product-sparepart-category/update{id_kategori_spare_part}', [SuperAdminProductSparePartController::class, 'updateCategory'])->name('product-sparepart-update');
Route::delete('product-sparepart-category/{id_kategori_spare_part}', [SuperAdminProductSparePartController::class, 'deleteCategory'])->name('product-sparepart-delete');

// Profile route
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::get('/profile/address', [ProfileController::class, 'showAddress'])->name('profile.address');
Route::get('/profile/address/create', [ProfileController::class, 'addAddress'])->name('profile.address.create');
Route::post('/profile/address/store', [ProfileController::class, 'storeAddress'])->name('address.store');
Route::get('/profile/address/edit/{id_alamat_pengiriman}', [ProfileController::class, 'editAddress'])->name('address.edit');
Route::post('/profile/address/update/{id_alamat_pengiriman}', [ProfileController::class, 'updateAddress'])->name('address.update');
Route::delete('/profile/address/delete/{id_alamat_pengiriman}', [ProfileController::class, 'delete'])->name('address.delete');
Route::get('profile/setting', [ProfileController::class, 'showSetting'])->name('profile.setting');
Route::post('/profile/reset-password', [ProfileController::class, 'resetPassword'])->name('profile.resetPassword');
Route::get('profile/used-car', [UsedCarController::class, 'showUsedCar'])->name('profile-used-car');
Route::get('profile/used-car/create', [UsedCarController::class, 'create'])->name('used-car-create');
Route::post('profile/used-car/store', [UsedCarController::class, 'store'])->name('used-car-store');
Route::get('profile/used-car', [UsedCarController::class, 'showUsedCar'])->name('profile-used-car');
Route::get('profile/used-car/create', [UsedCarController::class, 'create'])->name('used-car-create');
Route::post('profile/used-car/store', [UsedCarController::class, 'store'])->name('used-car-store');
Route::get('profile/used-car/edit/{id_mobil}', [UsedCarController::class, 'edit'])->name('used-car-edit');
Route::put('profile/used-car/update/{id_mobil}', [UsedCarController::class, 'update'])->name('used-car-update');
Route::delete('profile/used-car/delete/{id_mobil}', [UsedCarController::class, 'delete'])->name('used-car-delete');
Route::get('profile/workshop', [WorkshopController::class, 'showWorkshop'])->name('profile.workshop');
Route::get('profile/workshop/create', [WorkshopController::class, 'createWorkshop'])->name('profile.workshop.create');
Route::post('profile/workshop/store', [WorkshopController::class, 'storeWorkshop'])->name('profile.workshop.store');
Route::get('profile/workshop/edit/{id_bengkel}', [WorkshopController::class, 'editWorkshop'])->name('profile.workshop.edit');
Route::put('profile/workshop/update/{id_bengkel}', [WorkshopController::class, 'updateWorkshop'])->name('profile.workshop.update');
Route::delete('profile/workshop/destroy/{id_bengkel}', [WorkshopController::class, 'destroyWorkshop'])->name('profile.workshop.destroy');
Route::get('profile/workshop/detail/{id_bengkel}', [WorkshopController::class, 'detailWorkshop'])->name('profile.workshop.detail');
Route::get('profile/workshop/sparepart/create', [ProductSparePartController::class, 'createSparepart'])->name('profile.workshop.createSparepart');
Route::post('profile/workshop/sparepart/store', [ProductSparePartController::class, 'saveSparepart'])->name('profile.workshop.createSparepart.store');
Route::get('profile/workshop/sparepart/{id_spare_part}/edit', [ProductSparePartController::class, 'editSparepart'])->name('profile.workshop.sparepart.edit');
Route::post('profile/workshop/sparepart/{id_spare_part}/update', [ProductSparePartController::class, 'updateSparepart'])->name('profile.workshop.sparepart.update');
Route::delete('profile/workshop/sparepart/{id_spare_part}/delete', [ProductSparePartController::class, 'delete'])->name('profile.workshop.sparepart.delete');
Route::get('profile/workshop/service/create', [ServiceController::class, 'createService'])->name('profile.workshop.workshopSET.service.create');
Route::post('profile/workshop/service/store', [ServiceController::class, 'storeService'])->name('profile.workshop.workshopSET.service.store');
Route::get('profile/workshop/service/edit/{id_services}', [ServiceController::class, 'editService'])->name('profile.workshop.workshopSET.service.edit');
Route::put('profile/workshop/service/update/{id_services}', [ServiceController::class, 'updateService'])->name('profile.workshop.workshopSET.service.update');
Route::delete('profile/workshop/service/delete/{id_services}', [ServiceController::class, 'destroyService'])->name('profile.workshop.workshopSET.service.delete');
Route::get('profile/workshop/product/create', [ProductSparePartController::class, 'createProduct'])->name('profile.workshop.createProduct');
Route::post('profile/workshop/product/store', [ProductSparePartController::class, 'saveProduct'])->name('profile.workshop.createProduct.store');
Route::get('profile/workshop/product/{id_product}/edit', [ProductSparePartController::class, 'editProduct'])->name('profile.workshop.product.edit');
Route::post('profile/workshop/product/{id_product}/update', [ProductSparePartController::class, 'updateProduct'])->name('profile.workshop.product.update');
Route::delete('profile/workshop/product/{id_product}/delete', [ProductSparePartController::class, 'deleteProduct'])->name('profile.workshop.product.delete');
Route::get('profile/setting', [ProfileController::class, 'showSetting'])->name('profile.setting');
Route::post('/profile/reset-password', [ProfileController::class, 'resetPassword'])->name('profile.resetPassword');

// Event route
Route::get('event', [EventController::class, 'show'])->name('event.show');
Route::get('event/{id}', [EventController::class, 'detail'])->name('event.detail');
Route::get('event-daftar/{id_event}', [EventController::class, 'daftar'])->name('event.daftar');
Route::post('event/daftar/{id}', [EventController::class, 'store'])->name('event.store');


// Workshop route
Route::get('workshop', [WorkshopController::class, 'show'])->name('workshop.show');
Route::get('workshop/{id_bengkel}', [WorkshopController::class, 'detail'])->name('workshop.detail');

// Service Route
Route::get('/workshop/{id_bengkel}/service/{id_services}', [WorkshopController::class, 'detailService'])->name('service.detail');
// Route::get('/create', [WorkshopController::class, 'createWorkshop'])->name('profile.workshop.create');
// Route::post('/store', [WorkshopController::class, 'storeWorkshop'])->name('profile.workshop.store');
// Route::get('/edit/{id_bengkel}', [WorkshopController::class, 'editWorkshop'])->name('profile.workshop.edit');
// Route::put('/update/{id_bengkel}', [WorkshopController::class, 'updateWorkshop'])->name('profile.workshop.update');
// Route::delete('/delete/{id_bengkel}', [WorkshopController::class, 'destroyWorkshop'])->name('profile.workshop.destroy');
