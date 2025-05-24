<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;


// Controladores “globales”
use App\Http\Controllers\PrestamoController;

// Controladores de Admin (créate estas clases bajo app/Http/Controllers/Admin)
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DependenciaController;
use App\Http\Controllers\Admin\SerieController;
use App\Http\Controllers\Admin\SubserieController;
use App\Http\Controllers\Admin\SoporteController;
use App\Http\Controllers\Admin\UbicacionController;
use App\Http\Controllers\Inventarios\TransferenciaDocumentalController;
use App\Http\Controllers\Admin\AdminController;  // Asegúrate de que AdminController esté importado
use App\Http\Controllers\Inventarios\TipoDocumentalController;


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
        Route::resource('transferencias', TransferenciaDocumentalController::class);

        // Ruta de configuración
        Route::get('settings', [AdminController::class, 'settings'])->name('settings');  // Ruta para configuración
    });

// Rutas accesibles para cualquier usuario autenticado
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Inventario (Transferencias)
    Route::resource('inventario', TransferenciaDocumentalController::class)  // Cambié TransferenciaController a TransferenciaDocumentalController
        ->except(['show', 'edit', 'update', 'destroy']); // según permisos

    // Préstamos
    Route::resource('prestamos', PrestamoController::class);
});

// Ruta para obtener subseries por serie
Route::get('/subseries-por-serie/{serie_id}', function ($serie_id) {
    return \App\Models\SubserieDocumental::where('serie_documental_id', $serie_id)
        ->where('is_active', true)
        ->get(['id', 'nombre']);
})->middleware('auth')->name('subseries.por-serie');

// Rutas de inventarios (Transferencias)
Route::prefix('inventarios')
    ->name('inventarios.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        // Dependencias
        Route::resource('dependencias', DependenciaController::class);

        // Transferencias
        Route::resource('transferencias', TransferenciaDocumentalController::class);

        // Series + Subseries anidado
        Route::resource('series', SerieController::class);
        Route::resource('series.subseries', SubserieController::class);

        // Tipos Documentales
        Route::resource('tipos-documentales', TipoDocumentalController::class)
            ->parameters(['tipos-documentales' => 'tipo_documental']);
    });

// Password Reset
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;

// Password Reset
Route::get('/forgot-password', [ResetPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

// Email Verification
Route::get('/email/verify', [VerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth'])
    ->name('verification.resend');