<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MenuController;
use App\Http\Controllers\Frontend\ReservasiController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PaketController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PromoController;

// Auth Google
use App\Http\Controllers\Auth\GoogleController;

// ==================== FRONTEND ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/paket', [PaketController::class, 'index'])->name('paket');
Route::get('/lokasi', fn() => view('pages.lokasi'))->name('lokasi');
Route::get('/kontak', fn() => view('pages.kontak'))->name('kontak');
Route::get('/keranjang', fn() => view('pages.keranjang'))->name('keranjang');
Route::get('/promo/{id}', [App\Http\Controllers\Frontend\PromoController::class, 'show'])
    ->name('promo.show');
Route::post('/promo/cek', [App\Http\Controllers\Frontend\PromoController::class, 'cek'])
    ->name('promo.cek');

// Reservasi
Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi');
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store')->middleware('auth');

// Google Login
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// Login User
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// User (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/riwayat', [OrderController::class, 'index'])->name('riwayat');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    Route::post('/pesanan/{id}/batal', [OrderController::class, 'cancelByUser'])->name('order.cancel.user');
    Route::post('/pesanan/{id}/ajukan-batal', [OrderController::class, 'requestCancel'])->name('order.request.cancel');

    Route::get('/riwayat-reservasi', [ReservasiController::class, 'riwayat'])
        ->name('riwayat.reservasi');

        Route::post('/reservasi/{id}/batal', [ReservasiController::class, 'batal'])
        ->name('reservasi.batal');
});

// ==================== ADMIN AUTH ====================
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ==================== ADMIN (dilindungi) ====================
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Produk & Kategori
    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriController::class);

    // ===== PROMO =====
    Route::resource('promo', PromoController::class);
    
    // Reservasi
    Route::get('/reservasi', [AdminReservasiController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi/{id}/status', [AdminReservasiController::class, 'updateStatus'])->name('reservasi.status');
    Route::delete('/reservasi/{id}', [AdminReservasiController::class, 'destroy'])->name('reservasi.destroy');

    // Pesanan (Order)
    Route::get('/order', [AdminOrderController::class, 'index'])->name('order.index');
    Route::put('/order/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('order.status');
    Route::delete('/order/{id}', [AdminOrderController::class, 'destroy'])->name('order.destroy');
    Route::post('/order/{id}/cancel', [AdminOrderController::class, 'cancel'])->name('order.cancel');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});

