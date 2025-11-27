<?php

use App\Http\Controllers\Api\ReporteInundacionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MapaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcomeApp');
})->name('welcome');


Route::get('/mapa', function () {
    return view('mapa.index');
})->name('mapa');

Route::get('/refugios', function () {
    return view('refugios.index');
})->name('refugios');

Route::get('/informacion', function () {
    return view('info');
})->name('informacion');

Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    // Registro
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
  Route::get('/reportes', [ReporteInundacionController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/crear', [ReporteInundacionController::class, 'create'])->name('reportes.create');
    Route::post('/reportes', [ReporteInundacionController::class, 'store'])->name('reportes.store');
    Route::get('/reportes/{id}', [ReporteInundacionController::class, 'show'])->name('reportes.show');
    
    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::prefix('api')->group(function () {
    Route::apiResource('zonas-riesgo', \App\Http\Controllers\Api\ZonaRiesgoController::class);
    Route::apiResource('reportes', \App\Http\Controllers\Api\ReporteInundacionController::class);
    Route::apiResource('refugios', \App\Http\Controllers\Api\RefugioController::class);
    Route::apiResource('usuarios', \App\Http\Controllers\Api\UsuarioController::class)->only(['index', 'show']);
});