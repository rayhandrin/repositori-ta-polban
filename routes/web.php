<?php

use App\Http\Controllers\API\EmailVerificationController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\TugasAkhirController;
use App\Models\TugasAkhir;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/admin/mahasiswa');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('program-studi', ProgramStudiController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('tugas-akhir', TugasAkhirController::class);
    Route::get('storage/{filename}', [TugasAkhirController::class, 'accessFile'])->name('tugas-akhir.access');
});

// Email verification
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['signed'])->name('verification.verify');

// Reset password
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');
