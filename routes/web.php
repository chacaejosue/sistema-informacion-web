<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PanelController;

// Landing pública
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Catálogo público
Route::get('/categorias', function () {
    return view('categorias');
})->name('categorias');

// Rutas de autenticación (solo para visitantes sin sesión)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.authenticate');
});

// Cierre de sesión (para usuarios autenticados)
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Panel privado exclusivo para el rol CONSULTOR
Route::get('/panel', [PanelController::class, 'index'])
    ->middleware(['auth', 'rol.consultor'])
    ->name('panel');