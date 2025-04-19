<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

// Controladores “globales”
use App\Http\Controllers\Inventario\TransferenciaController;
use App\Http\Controllers\PrestamoController;


// Controladores de Admin (créate estas clases bajo app/Http/Controllers/Admin)
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DependenciaController;
use App\Http\Controllers\Admin\SerieController;
use App\Http\Controllers\Admin\SubserieController;
use App\Http\Controllers\Admin\SoporteController;
use App\Http\Controllers\Admin\UbicacionController;



Route::get('/', fn() => view('auth.login'));
//php artisan serve --host=0.0.0.0 --port=8000

Auth::routes();

// Rutas “admin/*” → solo admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Usuarios y Roles
        Route::resource('users', AdminUserController::class);
        Route::resource('roles', RoleController::class);

        // Catálogos maestros
        Route::resource('dependencias', DependenciaController::class);
        Route::resource('series', SerieController::class);
        Route::resource('subseries', SubserieController::class);
        Route::resource('soportes', SoporteController::class);
        Route::resource('ubicaciones', UbicacionController::class);

        // (Opcional) Reportes, configuraciones, etc.
    });

// Rutas accesibles para cualquier usuario autenticado
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Inventario (Transferencias)
    Route::resource('inventario', TransferenciaController::class)
        ->except(['show', 'edit', 'update', 'destroy']); // según permisos

    // Préstamos
    Route::resource('prestamos', PrestamoController::class);
});
