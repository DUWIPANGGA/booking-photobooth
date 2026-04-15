<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes (tanpa login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Auth routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Landing Page & Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $packages = \App\Models\Package::all();
    $galleryPhotos = \App\Models\GalleryPhoto::with('category')->latest()->take(6)->get();
    return view('landing', compact('packages', 'galleryPhotos'));
})->name('home');

Route::get('/paket', function() {
    $packages = \App\Models\Package::all();
    return view('user.paket', compact('packages'));
})->name('user.paket');

Route::get('/galeri', function () {
    return view('galeri.index');
})->name('galeri');

Route::get('/galeri/{theme}', function ($theme) {
    return view('galeri.show', ['theme' => $theme]);
})->name('galeri.show');

Route::get('/cara-transaksi', function () {
    return view('cara_transaksi');
})->name('cara_transaksi');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User routes
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');

        // Booking routes
        Route::get('/booking', [\App\Http\Controllers\BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [\App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');
        Route::get('/my-bookings', [\App\Http\Controllers\BookingController::class, 'index'])->name('booking.index');
        Route::get('/booking/{booking}', [\App\Http\Controllers\BookingController::class, 'show'])->name('booking.show');
        Route::delete('/booking/{booking}', [\App\Http\Controllers\BookingController::class, 'destroy'])->name('booking.destroy');
    });

    // Admin routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // Gallery Management
        Route::get('/galeri', [\App\Http\Controllers\AdminCategoryController::class, 'index'])->name('admin.galeri.index');
        Route::get('/galeri/create', [\App\Http\Controllers\AdminCategoryController::class, 'create'])->name('admin.galeri.create');
        Route::post('/galeri', [\App\Http\Controllers\AdminCategoryController::class, 'store'])->name('admin.galeri.store');
        Route::get('/galeri/{category}/edit', [\App\Http\Controllers\AdminCategoryController::class, 'edit'])->name('admin.galeri.edit');
        Route::put('/galeri/{category}', [\App\Http\Controllers\AdminCategoryController::class, 'update'])->name('admin.galeri.update');
        Route::delete('/galeri/{category}', [\App\Http\Controllers\AdminCategoryController::class, 'destroy'])->name('admin.galeri.destroy');
        
        // Package Management
        Route::get('/paket', [\App\Http\Controllers\AdminPackageController::class, 'index'])->name('admin.paket.index');
        Route::get('/paket/create', [\App\Http\Controllers\AdminPackageController::class, 'create'])->name('admin.paket.create');
        Route::post('/paket', [\App\Http\Controllers\AdminPackageController::class, 'store'])->name('admin.paket.store');
        Route::get('/paket/{package}/edit', [\App\Http\Controllers\AdminPackageController::class, 'edit'])->name('admin.paket.edit');
        Route::put('/paket/{package}', [\App\Http\Controllers\AdminPackageController::class, 'update'])->name('admin.paket.update');
        Route::delete('/paket/{package}', [\App\Http\Controllers\AdminPackageController::class, 'destroy'])->name('admin.paket.destroy');
        // Booking Management
        Route::get('/booking', [\App\Http\Controllers\AdminBookingController::class, 'index'])->name('admin.booking.index');
        Route::put('/booking/{booking}/status', [\App\Http\Controllers\AdminBookingController::class, 'updateStatus'])->name('admin.booking.updateStatus');
        Route::put('/booking/{booking}/reschedule', [\App\Http\Controllers\AdminBookingController::class, 'reschedule'])->name('admin.booking.reschedule');
        Route::delete('/booking/{booking}', [\App\Http\Controllers\AdminBookingController::class, 'destroy'])->name('admin.booking.destroy');

        // Profile Management
        Route::get('/profile', [\App\Http\Controllers\AdminController::class, 'profile'])->name('admin.profile');
        Route::put('/profile', [\App\Http\Controllers\AdminController::class, 'profileUpdate'])->name('admin.profile.update');
    });
});
