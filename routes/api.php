<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HakAksesAPIController;
use App\Http\Controllers\API\TugasAkhirAPIController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest')->prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/jurusan', [TugasAkhirAPIController::class, 'jurusan']);
    Route::get('/jurusan/{jurusan}/program-studi', [TugasAkhirAPIController::class, 'prodi']);
    Route::get('/program-studi/{nomor_prodi}/tugas-akhir', [TugasAkhirAPIController::class, 'tugasAkhir']);
    Route::get('/tugas-akhir/{id}', [TugasAkhirAPIController::class, 'tugasAkhirDetail']);
    Route::get('/hak-akses/{nim}', [HakAksesAPIController::class, 'getHakAksesMahasiswa']);
    Route::post('/hak-akses/{nim}', [HakAksesAPIController::class, 'createHakAkses']);
    Route::get('/hak-akses-detail/{id}', [HakAksesAPIController::class, 'getDetailHistory']);
});
