<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DependenciaController;
use App\Http\Controllers\Admin\SerieController;
use App\Http\Controllers\Admin\SubserieController;
use App\Http\Controllers\Admin\UbicacionController;
use App\Http\Controllers\Inventarios\TipoDocumentalController;
use App\Http\Controllers\Inventarios\TransferenciaDocumentalController;
use App\Http\Controllers\Inventarios\SoporteController;
use App\Http\Controllers\PerfilController;


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
        // Ruta para configuración
    });

Route::middleware(['auth'])->group(function () {
    Route::get('perfil', [PerfilController::class, 'index'])->name('perfiles.index');
    Route::get('perfil/edit', [PerfilController::class, 'edit'])->name('perfiles.edit');
    Route::post('perfil/update', [PerfilController::class, 'update'])->name('perfiles.update');
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

        Route::patch(
            'transferencias/{t}/firmar-entregado',
            [TransferenciaDocumentalController::class, 'firmarEntregado']
        )
            ->name('transferencias.firmar.entregado')
            ->middleware('auth');

        Route::patch(
            'transferencias/{t}/firmar-recibido',
            [TransferenciaDocumentalController::class, 'firmarRecibido']
        )
            ->name('transferencias.firmar.recibido')
            ->middleware('auth');

        Route::patch(
            'transferencias/{t}/archivar',
            [TransferenciaDocumentalController::class, 'archivar']
        )
            ->name('transferencias.archivar')
            ->middleware('auth');

        // Series + Subseries anidado
        Route::resource('series', SerieController::class);
        Route::resource('series.subseries', SubserieController::class);

        // Tipos Documentales
        Route::resource('tipos-documentales', TipoDocumentalController::class)
            ->parameters(['tipos-documentales' => 'tipo_documental']);

        Route::resource('ubicaciones', UbicacionController::class)
            ->parameters(['ubicaciones' => 'ubicacion'])
            ->except(['show']);

        Route::resource('soportes', SoporteController::class)
            ->except(['show']);
    });
