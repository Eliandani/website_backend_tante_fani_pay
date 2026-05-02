<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebTransactionController;

// Dashboard
Route::get('/', [WebTransactionController::class, 'dashboard'])->name('dashboard');

// Web Transaction CRUD
Route::resource('transaksi', WebTransactionController::class)->except(['show'])->parameters([
    'transaksi' => 'transaction',
]);
