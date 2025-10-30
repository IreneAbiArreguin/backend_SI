<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Agrega esto al final:
Route::prefix('api')->group(function () {
    Route::apiResource('zonas-riesgo', \App\Http\Controllers\Api\ZonaRiesgoController::class);
    Route::apiResource('reportes', \App\Http\Controllers\Api\ReporteInundacionController::class);
    Route::apiResource('refugios', \App\Http\Controllers\Api\RefugioController::class);
    Route::apiResource('usuarios', \App\Http\Controllers\Api\UsuarioController::class)->only(['index', 'show']);
});