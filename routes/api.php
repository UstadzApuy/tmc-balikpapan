<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StreamingController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Streaming API routes
Route::prefix('streaming')->group(function () {
    Route::get('/status', [StreamingController::class, 'allStatus']);
    Route::get('/status/{id}', [StreamingController::class, 'status']);
    Route::post('/start/{id}', [StreamingController::class, 'start']);
    Route::post('/stop/{id}', [StreamingController::class, 'stop']);
});

// CCTV API routes
Route::prefix('cctv')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\CctvController::class, 'index']);
    Route::get('/{id}', [\App\Http\Controllers\Api\CctvController::class, 'show']);
    Route::get('/location/{locationId}', [\App\Http\Controllers\Api\CctvController::class, 'getByLocation']);
});
