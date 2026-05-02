<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebTransactionController;
use App\Http\Controllers\AuthController;

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Logout (auth only)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [WebTransactionController::class, 'dashboard'])->name('dashboard');

    // Change Password
    Route::get('/ubah-password', [AuthController::class, 'showChangePassword'])->name('password.change');
    Route::post('/ubah-password', [AuthController::class, 'changePassword'])->name('password.update');

    // Web Transaction CRUD
    Route::resource('transaksi', WebTransactionController::class)->except(['show'])->parameters([
        'transaksi' => 'transaction',
    ]);
});
