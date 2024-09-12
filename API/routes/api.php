<?php
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;

// Ruta de login sin middleware especial
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas por Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::post('/blogs', [BlogController::class, 'store']);
});
