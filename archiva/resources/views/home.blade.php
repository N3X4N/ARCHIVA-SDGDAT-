<x-admin-layout>
    <x-slot name="title">
        Dashboard - {{ auth()->user()->name }}
    </x-slot>

    <div class="container mt-4">
        <h1>Dashboard Resumen</h1>

        <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">

            <div class="col">
                <div class="card bg-primary text-white shadow h-100 d-flex flex-row align-items-center p-3">
                    <div class="me-3">
                        <i class="bi bi-people-fill" style="font-size: 3rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title">Usuarios</h5>
                        <p class="display-4 mb-0">{{ $totalUsuarios }}</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card bg-success text-white shadow h-100 d-flex flex-row align-items-center p-3">
                    <div class="me-3">
                        <i class="bi bi-arrow-left-right" style="font-size: 3rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title">Transferencias</h5>
                        <p class="display-4 mb-0">{{ $totalTransferencias }}</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card bg-warning text-white shadow h-100 d-flex flex-row align-items-center p-3">
                    <div class="me-3">
                        <i class="bi bi-geo-alt-fill" style="font-size: 3rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title">Ubicaciones</h5>
                        <p class="display-4 mb-0">{{ $totalUbicaciones }}</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card bg-info text-white shadow h-100 d-flex flex-row align-items-center p-3">
                    <div class="me-3">
                        <i class="bi bi-person-badge-fill" style="font-size: 3rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title">Roles</h5>
                        <p class="display-4 mb-0">{{ $totalRoles }}</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card bg-secondary text-white shadow h-100 d-flex flex-row align-items-center p-3">
                    <div class="me-3">
                        <i class="bi bi-building" style="font-size: 3rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title">Dependencias</h5>
                        <p class="display-4 mb-0">{{ $totalDependencias }}</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card bg-dark text-white shadow h-100 d-flex flex-row align-items-center p-3">
                    <div class="me-3">
                        <i class="bi bi-file-earmark-text-fill" style="font-size: 3rem;"></i>
                    </div>
                    <div>
                        <h5 class="card-title">Soportes</h5>
                        <p class="display-4 mb-0">{{ $totalSoportes }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
