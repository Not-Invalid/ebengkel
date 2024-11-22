<?php

use App\Http\Controllers\AuthController as PelangganAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MyorderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Pos\AuthController as PosAuthController;
use App\Http\Controllers\Pos\HomeController as PosHomeController;
use App\Http\Controllers\Pos\ProductController as PosProductController;
use App\Http\Controllers\ProductSparePartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SuperAdmin\AuthController as SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\BlogController as SuperAdminBlogController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\DataPelangganController as SuperAdminPelangganController;
use App\Http\Controllers\SuperAdmin\EventController as SuperAdminEventController;
use App\Http\Controllers\SuperAdmin\KategoriBlogController as SuperAdminKategoriBlogController;
use App\Http\Controllers\SuperAdmin\MerkMobilController;
use App\Http\Controllers\SuperAdmin\MessagesController as SuperAdminMessagesController;
use App\Http\Controllers\SuperAdmin\ProductSparepartController as SuperAdminProductSparePartController;
use App\Http\Controllers\SuperAdmin\ProfileController as SuperAdminProfileController;
use App\Http\Controllers\SuperAdmin\SettingsController as SuperAdminSettingsController;
use App\Http\Controllers\SuperAdmin\StaffController;
use App\Http\Controllers\SuperAdmin\SupportCenterController;
use App\Http\Controllers\SuperAdmin\WorkshopController as SuperAdminWorkshopController;
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

    Route::get('cart', [CartController::class, 'showCart'])->name('cart');
    Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{itemId}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
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
    Route::delete('event-data/delete/{id}', [SuperAdminEventController::class, 'delete'])->name('event-delete');
    Route::get('/event/{eventId}/daftar-peserta', [SuperAdminEventController::class, 'showPesertaEvent'])->name('event-peserta');

    Route::get('merk-mobil', [MerkMobilController::class, 'index'])->name('merk-mobil');
    Route::get('merk-mobil/create', [MerkMobilController::class, 'create'])->name('merk-mobil-create');
    Route::post('merk-mobil/store', [MerkMobilController::class, 'store'])->name('merk-mobil-send');
    Route::get('merk-mobil/edit/{id}', [MerkMobilController::class, 'edit'])->name('merk-mobil-edit');
    Route::post('merk-mobil/update/{id}', [MerkMobilController::class, 'update'])->name('merk-mobil-update');
    Route::delete('merk-mobil/delete/{id}', [MerkMobilController::class, 'delete'])->name('merk-mobil-delete');

    Route::get('blog-admin', [SuperAdminBlogController::class, 'index'])->name('blog-admin');
    Route::get('blog/create', [SuperAdminBlogController::class, 'create'])->name('blog-admin-create');
    Route::post('blog/store', [SuperAdminBlogController::class, 'store'])->name('blog-admin-store');
    Route::get('blog/edit/{id}', [SuperAdminBlogController::class, 'edit'])->name('blog-admin-edit');
    Route::post('blog/update/{id}', [SuperAdminBlogController::class, 'update'])->name('blog-admin-update');
    Route::delete('blog/delete/{id}', [SuperAdminBlogController::class, 'delete'])->name('blog-admin-delete');

    Route::get('inbox', [SuperAdminMessagesController::class, 'index'])->name('inbox');

    Route::get('workshop', [SuperAdminWorkshopController::class, 'index'])->name('workshop-data');
    Route::get('workshop/detail/{id}', [SuperAdminWorkshopController::class, 'detail'])->name('workshop-detail');

    Route::get('data-pelanggan', [SuperAdminPelangganController::class, 'index'])->name('data-pelanggan');

    Route::get('profile', [SuperAdminProfileController::class, 'index'])->name('profile-admin');
    Route::post('profile/{id}', [SuperAdminProfileController::class, 'update'])->name('profile-update');

    Route::get('product-sparepart-category', [SuperAdminProductSparePartController::class, 'showCategory'])->name('product-sparepart-category');
    Route::get('product-sparepart-category/create', [SuperAdminProductSparePartController::class, 'createCategory'])->name('product-sparepart-create');
    Route::post('product-sparepart-category/store', [SuperAdminProductSparePartController::class, 'storeCategory'])->name('product-sparepart-send');
    Route::get('product-sparepart-category/edit/{id_kategori_spare_part}', [SuperAdminProductSparePartController::class, 'editCategory'])->name('product-sparepart-edit');
    Route::post('product-sparepart-category/update{id_kategori_spare_part}', [SuperAdminProductSparePartController::class, 'updateCategory'])->name('product-sparepart-update');
    Route::delete('product-sparepart-category/{id_kategori_spare_part}', [SuperAdminProductSparePartController::class, 'deleteCategory'])->name('product-sparepart-delete');

    Route::get('blog-category', [SuperAdminKategoriBlogController::class, 'index'])->name('blog-category');
    Route::get('blog-category/create', [SuperAdminKategoriBlogController::class, 'create'])->name('blog-category-create');
    Route::post('blog-category/store', [SuperAdminKategoriBlogController::class, 'store'])->name('blog-category-send');
    Route::get('blog-category/edit/{id}', [SuperAdminKategoriBlogController::class, 'edit'])->name('blog-category-edit');
    Route::post('blog-category/update{id}', [SuperAdminKategoriBlogController::class, 'update'])->name('blog-category-update');
    Route::delete('blog-category/{id}', [SuperAdminKategoriBlogController::class, 'delete'])->name('blog-category-delete');

    Route::get('staff-admin', [StaffController::class, 'index'])->name('data-staff-admin');
    Route::get('staff-admin/create', [StaffController::class, 'create'])->name('data-staff-create');
    Route::post('staff-admin/store', [StaffController::class, 'store'])->name('data-staff-send');
    Route::get('staff-admin/edit/{id}', [StaffController::class, 'edit'])->name('data-staff-edit');
    Route::post('staff-admin/update/{id}', [StaffController::class, 'update'])->name('data-staff-update');
    Route::delete('staff-admin/delete/{id}', [StaffController::class, 'delete'])->name('data-staff-delete');

    Route::get('settings/change-password', [SuperAdminSettingsController::class, 'index'])->name('change-password');
    Route::post('/reset-password', [SuperAdminSettingsController::class, 'resetPassword'])->name('reset-password');

});

// UsedCar
Route::prefix('used-car')->group(function () {
    Route::get('/', [UsedCarController::class, 'index'])->name('used-car');
    Route::get('detail/{id_mobil}', [UsedCarController::class, 'detail'])->name('usedcar.detail');
});

// Product & SparePart
Route::prefix('ProductsSparePart')->group(function () {
    Route::get('/', [ProductSparePartController::class, 'index'])->name('ProductSparePart');
    Route::get('/detail/{type}/{id}', [ProductSparePartController::class, 'detail'])->name('Detail-ProductSparePart');
});

// Event route
Route::prefix('event')->group(function () {
    Route::get('/', [EventController::class, 'show'])->name('event.show');
    Route::get('event-detail/{id}', [EventController::class, 'detail'])->name('event.detail');
    Route::get('event-daftar/{id_event}', [EventController::class, 'daftar'])->name('event.daftar');
    Route::post('event/daftar/{id}', [EventController::class, 'store'])->name('event.store');
});

Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.show');
});

// Workshop route
Route::prefix('workshop')->group(function () {
    Route::get('/', [WorkshopController::class, 'show'])->name('workshop.show');
    Route::get('workshop-detail/{id_bengkel}', [WorkshopController::class, 'detail'])->name('workshop.detail');
    Route::get('workshop/{id_bengkel}/service/{id_services}', [WorkshopController::class, 'detailService'])->name('service.detail');
    Route::post('workshop/review/store', [WorkshopController::class, 'storeReview'])->name('ulasan.store');
});

// Pages Routes
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

// Profile route
Route::prefix('profile')->group(function () {
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');

    // address
    Route::prefix('address')->group(function () {
        Route::get('/', [ProfileController::class, 'showAddress'])->name('profile.address');
        Route::get('create', [ProfileController::class, 'addAddress'])->name('profile.address.create');
        Route::post('store', [ProfileController::class, 'storeAddress'])->name('address.store');
        Route::get('edit/{id_alamat_pengiriman}', [ProfileController::class, 'editAddress'])->name('address.edit');
        Route::post('update/{id_alamat_pengiriman}', [ProfileController::class, 'updateAddress'])->name('address.update');
        Route::delete('delete/{id_alamat_pengiriman}', [ProfileController::class, 'delete'])->name('address.delete');
    });

    // workshop
    Route::prefix('workshop')->group(function () {
        Route::get('/', [WorkshopController::class, 'showWorkshop'])->name('profile.workshop');
        Route::get('create', [WorkshopController::class, 'createWorkshop'])->name('profile.workshop.create');
        Route::post('store', [WorkshopController::class, 'storeWorkshop'])->name('profile.workshop.store');
        Route::get('edit/{id_bengkel}', [WorkshopController::class, 'editWorkshop'])->name('profile.workshop.edit');
        Route::put('update/{id_bengkel}', [WorkshopController::class, 'updateWorkshop'])->name('profile.workshop.update');
        Route::delete('destroy/{id_bengkel}', [WorkshopController::class, 'destroyWorkshop'])->name('profile.workshop.destroy');
        Route::get('detail/{id_bengkel}', [WorkshopController::class, 'detailWorkshop'])->name('profile.workshop.detail');
        Route::get('sparepart/create', [ProductSparePartController::class, 'createSparepart'])->name('profile.workshop.createSparepart');
        Route::post('sparepart/store', [ProductSparePartController::class, 'saveSparepart'])->name('profile.workshop.createSparepart.store');
        Route::get('sparepart/{id_spare_part}/edit', [ProductSparePartController::class, 'editSparepart'])->name('profile.workshop.sparepart.edit');
        Route::post('sparepart/{id_spare_part}/update', [ProductSparePartController::class, 'updateSparepart'])->name('profile.workshop.sparepart.update');
        Route::delete('sparepart/{id_spare_part}/delete', [ProductSparePartController::class, 'delete'])->name('profile.workshop.sparepart.delete');
        Route::get('service/create', [ServiceController::class, 'createService'])->name('profile.workshop.workshopSET.service.create');
        Route::post('service/store', [ServiceController::class, 'storeService'])->name('profile.workshop.workshopSET.service.store');
        Route::get('service/edit/{id_services}', [ServiceController::class, 'editService'])->name('profile.workshop.workshopSET.service.edit');
        Route::put('service/update/{id_services}', [ServiceController::class, 'updateService'])->name('profile.workshop.workshopSET.service.update');
        Route::delete('service/delete/{id_services}', [ServiceController::class, 'destroyService'])->name('profile.workshop.workshopSET.service.delete');
        Route::get('product/create', [ProductSparePartController::class, 'createProduct'])->name('profile.workshop.createProduct');
        Route::post('product/store', [ProductSparePartController::class, 'saveProduct'])->name('profile.workshop.createProduct.store');
        Route::get('product/{id_product}/edit', [ProductSparePartController::class, 'editProduct'])->name('profile.workshop.product.edit');
        Route::post('product/{id_product}/update', [ProductSparePartController::class, 'updateProduct'])->name('profile.workshop.product.update');
        Route::delete('product/{id_product}/delete', [ProductSparePartController::class, 'deleteProduct'])->name('profile.workshop.product.delete');
    });

    // used car
    Route::prefix('used-car')->group(function () {
        Route::get('/', [UsedCarController::class, 'showUsedCar'])->name('profile-used-car');
        Route::get('create', [UsedCarController::class, 'create'])->name('used-car-create');
        Route::post('store', [UsedCarController::class, 'store'])->name('used-car-store');
        Route::get('edit/{id_mobil}', [UsedCarController::class, 'edit'])->name('used-car-edit');
        Route::put('update/{id_mobil}', [UsedCarController::class, 'update'])->name('used-car-update');
        Route::delete('delete/{id_mobil}', [UsedCarController::class, 'delete'])->name('used-car-delete');
    });

    // settings
    Route::prefix('settings')->group(function () {
        Route::get('/', [ProfileController::class, 'showSetting'])->name('profile.setting');
        Route::post('reset-password', [ProfileController::class, 'resetPassword'])->name('profile.resetPassword');

    });

    //payment
    Route::prefix('my-order')->group(function () {
        Route::get('/', [MyorderController::class, 'index'])->name('my-order.index');
    });
});

Route::prefix('POS')->group(function () {
    Route::get('pos/redirect/{id_bengkel}', [PosAuthController::class, 'redirectToPos'])->name('pos.redirect');
    Route::get('register/{id_bengkel}', [PosAuthController::class, 'showregister'])->name('pos.register.show');
    Route::post('register', [PosAuthController::class, 'register'])->name('pos.register');
    Route::get('login/{id_bengkel}', [PosAuthController::class, 'showlogin'])->name('pos.login.show');
    Route::post('login', [PosAuthController::class, 'login'])->name('pos.login');
    Route::post('logout', [PosAuthController::class, 'logout'])->name('pos.logout');

    Route::get('home/{id_bengkel}', [PosHomeController::class, 'index'])->name('pos.index');

    Route::prefix('Master-data')->group(function () {
        Route::prefix('pos/{id_bengkel}/product')->group(function () {
            Route::get('/', [PosProductController::class, 'index'])->name('pos.product.index');
            Route::get('create', [PosProductController::class, 'create'])->name('pos.product.create');
            Route::post('store', [PosProductController::class, 'store'])->name('pos.product.store');
            Route::get('edit/{id_produk}', [PosProductController::class, 'edit'])->name('pos.product.edit');
            Route::put('update/{id_produk}', [PosProductController::class, 'update'])->name('pos.product.update');
            Route::delete('delete/{id_produk}', [PosProductController::class, 'destroy'])->name('pos.product.destroy');
        });
    });

});
