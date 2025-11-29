<?php

use App\Http\Controllers\ReporteInundacionController;
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
    Route::get('/mis-reportes', [ReporteInundacionController::class, 'index'])->name('reportes.index');
    Route::get('/mis-reportes/crear', [ReporteInundacionController::class, 'create'])->name('reportes.create');
    Route::post('/mis-reportes', [ReporteInundacionController::class, 'store'])->name('reportes.store');
    Route::get('/mis-reportes/{id}', [ReporteInundacionController::class, 'show'])->name('reportes.show');
    
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

