<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;



/*S
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

route::middleware('is_admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/kategori', KategoriController::class);


Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');

// Peminjaman routes
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');

// Pengembalian routes
Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
Route::post('/pengembalian/{id}/approve', [PengembalianController::class, 'approve'])->name('pengembalian.approve');
Route::post('/pengembalian/{id}/reject', [PengembalianController::class, 'reject'])->name('pengembalian.reject');
Route::get('/pengembalian/{id}/mark-damage', [PengembalianController::class, 'markDamageForm'])->name('pengembalian.markDamage.form');
Route::post('/pengembalian/{id}/mark-damage', [PengembalianController::class, 'markDamage'])->name('pengembalian.markDamage');
});










