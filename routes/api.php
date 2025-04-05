<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MusicaController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/musicas', [MusicaController::class, 'index']);
Route::get('/musicas/{id}', [MusicaController::class, 'show']);
Route::post('/musicas', [MusicaController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/musicas', [MusicaController::class, 'store']);
    
    Route::middleware('role:user')->group(function () {
        
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::put('/musicas/{id}/status', [MusicaController::class, 'updateStatus'])->middleware('auth:sanctum');
        Route::put('/musicas/{id}', [MusicaController::class, 'update']);
        Route::delete('/musicas/{id}', [MusicaController::class, 'destroy']);
    });


});
