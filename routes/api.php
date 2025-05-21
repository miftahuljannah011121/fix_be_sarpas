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

route::post('/login', [AuthController::class, 'login']);

route::prefix('v1')->group(function () {
    // Barang routes
    route::get('/barang', [BarangController::class, 'index']);

    // Peminjaman routes
    route::post('/peminjaman', [PeminjamanController::class, 'store']);
    route::get('/peminjaman', [PeminjamanController::class, 'index']);

    // Pengembalian routes
    route::post('/pengembalian', [PengembalianController::class, 'store']);
});
