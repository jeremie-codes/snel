<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RateController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('payments', PaymentController::class)
        ->only(['index', 'show', 'create', 'store']);

    Route::resource('factures', FactureController::class)
        ->only(['index', 'show', 'create', 'store', 'destroy']);

    Route::resource('clients', ClientController::class);
    Route::resource('users', UserController::class);

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('rate/store', [RateController::class, 'store'])->name('rate.store');

    Route::get('/payments/{payment}/print', [PaymentController::class, 'printInvoice'])
    ->name('payments.print');

    Route::get('/factues/{facture}/invoice-print', [FactureController::class, 'printInvoicePdf'])
    ->name('factures.invoice-print');

    //Route::get('/payments/{payment}/export-pdf', [PaymentController::class, 'exportPdf'])
    //->name('payments.export-pdf');
});
