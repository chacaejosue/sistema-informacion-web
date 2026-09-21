<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\LineaController;

// Landing pública
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Catálogo público conectado a MySQL
Route::get('/categorias', [CatalogoController::class, 'index'])->name('categorias');

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
Route::middleware(['auth', 'rol.consultor'])->prefix('panel')->group(function () {
    Route::get('/', [PanelController::class, 'index'])->name('panel');

    // Subrutas de gestión del panel
    Route::name('panel.')->group(function () {
        Route::get('/index', [PanelController::class, 'index'])->name('index');

        // CRUD de Productos
        Route::patch('productos/{producto}/toggle', [ProductoController::class, 'toggleStatus'])->name('productos.toggle');
        Route::resource('productos', ProductoController::class);

        // CRUD de Proveedores, Categorías y Líneas
        Route::resource('proveedores', ProveedorController::class)->except(['create', 'show', 'edit']);
        Route::resource('categorias', CategoriaController::class)->except(['create', 'show', 'edit']);
        Route::resource('lineas', LineaController::class)->except(['create', 'show', 'edit']);
    });
});