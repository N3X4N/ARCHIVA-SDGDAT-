<x-admin-layout>
    <x-slot name="title">Mi Perfil</x-slot>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">
                <i class="fa fa-user-circle me-2"></i> Mi Perfil
            </h1>
            <a href="{{ route('perfiles.edit') }}" class="btn btn-outline-primary">
                <i class="fa fa-pen me-1"></i> Editar Perfil
            </a>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa fa-user me-1"></i> Datos del Usuario
                        </h5>
                        <hr>
                        <p><i class="fa fa-envelope me-2 text-primary"></i><strong>Correo:</strong> {{ $user->email }}</p>
                        <p><i class="fa fa-shield-alt me-2 text-primary"></i><strong>Rol:</strong> {{ $user->role->nombre_rol ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fa fa-id-card me-1"></i> Datos del Perfil
                        </h5>
                        <hr>
                        <p><i class="fa fa-user-tag me-2 text-primary"></i><strong>Nombres:</strong> {{ $perfil->nombres ?? '-' }}</p>
                        <p><i class="fa fa-user-tag me-2 text-primary"></i><strong>Apellidos:</strong> {{ $perfil->apellidos ?? '-' }}</p>
                        <p><i class="fa fa-building me-2 text-primary"></i><strong>Dependencia:</strong> {{ $perfil->dependencia->nombre ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="fa fa-signature me-1"></i> Firma Digital
                        </h5>
                        <hr>
                        @if ($perfil && $perfil->firma_digital)
                            <img src="{{ asset('storage/' . $perfil->firma_digital) }}" alt="Firma Digital" class="img-fluid rounded" style="max-height: 200px;">
                            <p class="mt-2">
                                <a href="{{ Storage::url($perfil->firma_digital) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fa fa-eye"></i> Ver Firma Completa
                                </a>
                            </p>
                        @else
                            <p class="text-muted">No registrada</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
