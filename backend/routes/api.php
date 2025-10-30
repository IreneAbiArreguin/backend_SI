<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ZonaRiesgoController;
use App\Http\Controllers\Api\ReporteInundacionController;
use App\Http\Controllers\Api\RefugioController;
use App\Http\Controllers\Api\UsuarioController;

Route::apiResource('zonas-riesgo', ZonaRiesgoController::class);
Route::apiResource('reportes', ReporteInundacionController::class);
Route::apiResource('refugios', RefugioController::class);
Route::apiResource('usuarios', UsuarioController::class)->only(['index', 'show']);

?>