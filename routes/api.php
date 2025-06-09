<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\API\PeminjamanController;
use App\Http\Controllers\Api\PengembalianController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
    

Route::get('/barang', [BarangController::class, 'index']);

Route::get('/peminjaman', [PeminjamanController::class, 'index']);       // Semua peminjaman (admin)
Route::get('/peminjaman/user', [PeminjamanController::class, 'getByUser']);  // Peminjaman user login
Route::post('/peminjaman', [PeminjamanController::class, 'store']);      // Buat peminjaman baru

// Semua route peminjaman dengan middleware auth:sanctum (sesuaikan jika kamu pakai auth lain)
Route::middleware('auth:sanctum')->group(function () {

});



