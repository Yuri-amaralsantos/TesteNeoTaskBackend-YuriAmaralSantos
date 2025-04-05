<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicaController;
use Illuminate\Http\Middleware\HandleCors;

Route::middleware([HandleCors::class])->group(function () {
    Route::get('/test', fn () => response()->json(['status' => 'CORS working']));
});

Route::get('/', function () {
    return view('welcome');
});


