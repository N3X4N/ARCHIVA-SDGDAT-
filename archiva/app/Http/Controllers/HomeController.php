<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TransferenciaDocumental;
use App\Models\Ubicacion;
use App\Models\Role;
use App\Models\Dependencia;
use App\Models\Soporte;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Conteos para mostrar en dashboard
        $totalUsuarios = User::count();
        $totalTransferencias = TransferenciaDocumental::count();
        $totalUbicaciones = Ubicacion::count();
        $totalRoles = Role::count();
        $totalDependencias = Dependencia::count();
        $totalSoportes = Soporte::count();

        return view('home', compact(
            'totalUsuarios',
            'totalTransferencias',
            'totalUbicaciones',
            'totalRoles',
            'totalDependencias',
            'totalSoportes'
        ));
    }
}
