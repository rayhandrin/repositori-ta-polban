<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\API\EmailVerificationController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\ProgramStudiController;
use App\Http\Controllers\Admin\TugasAkhirController;
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

Route::redirect('/', '/admin');

Route::get('/admin', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/admin', [LoginController::class, 'authenticate'])->middleware('guest');

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('program-studi/import', [ProgramStudiController::class, 'importPage'])->name('program-studi.import');
    Route::get('program-studi/import/template', [ProgramStudiController::class, 'downloadTemplate'])->name('program-studi.template');
    Route::post('program-studi/import', [ProgramStudiController::class, 'import']);
    Route::resource('program-studi', ProgramStudiController::class);

    Route::resource('mahasiswa', MahasiswaController::class);

    Route::resource('tugas-akhir', TugasAkhirController::class);
    Route::get('storage/{filename}', [TugasAkhirController::class, 'accessFile'])->name('tugas-akhir.access');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Email verification
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['signed'])->name('verification.verify');

// Reset password
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');
