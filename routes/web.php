<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('clients', \App\Http\Controllers\ClientController::class);
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    // Route::resource('tasks', \App\Http\Controllers\TaskController::class);
    Route::get('invoices/{invoice}/download', [\App\Http\Controllers\InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('invoices/{invoice}/preview', [\App\Http\Controllers\InvoiceController::class, 'preview'])->name('invoices.preview');
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);
    Route::resource('quotations', \App\Http\Controllers\QuotationController::class);

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__ . '/auth.php';
