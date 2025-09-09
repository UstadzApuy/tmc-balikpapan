<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController as ApiNewsController;
use App\Http\Controllers\Api\CctvStreamController as ApiCctvStreamController;

// Web routes
Route::get('/', [\App\Http\Controllers\Web\HomeController::class, 'index']);
Route::get('/cctv/{id}', [\App\Http\Controllers\Web\CctvController::class, 'show'])->name('cctv.show');
Route::get('/cctv/{id}/modal', [\App\Http\Controllers\Web\CctvController::class, 'modal'])->name('cctv.modal');
Route::get('/streaming', [\App\Http\Controllers\Web\StreamingController::class, 'index'])->name('streaming');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// API routes
Route::prefix('api')->group(function () {
    Route::get('news', [ApiNewsController::class, 'index']);
    Route::get('news/{id}', [ApiNewsController::class, 'show']);
    Route::get('cctv/{id}/stream', [ApiCctvStreamController::class, 'stream']);
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::redirect('/', '/admin/dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // News Management
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::post('news/{news}/toggle-status', [\App\Http\Controllers\Admin\NewsController::class, 'toggleStatus'])->name('news.toggle-status');
    Route::post('/dashboard/update-news', [\App\Http\Controllers\Admin\DashboardController::class, 'updateNews'])->name('dashboard.update-news');
    
    // Location Management
    Route::resource('locations', \App\Http\Controllers\Admin\LocationController::class);
    
    // CCTV Management
    Route::resource('cctvs', \App\Http\Controllers\Admin\CctvController::class);
    
    // Contact Management
    Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class)->except([
        'create', 'store', 'destroy'
    ]);
    
    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});

// Auth routes
require __DIR__.'/auth.php';
