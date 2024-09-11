<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;


Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/blogs', [BlogController::class, 'index']); // Ver todos los blogs
    Route::post('/blogs', [BlogController::class, 'store']); // Crear un nuevo blog
    Route::put('/blogs/{id}', [BlogController::class, 'update']); // Editar un blog
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy']); // Eliminar un blog
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    \Log::info('Usuario autenticado:', ['user' => $request->user()]);
    return $request->user();
});

