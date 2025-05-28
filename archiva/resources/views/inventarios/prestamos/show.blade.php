<x-admin-layout>
    <x-slot name="title">Detalle del Préstamo #{{ $prestamo->id }}</x-slot>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Detalle del Préstamo #{{ $prestamo->id }}</h1>
            <div>
                <a href="{{ route('prestamos.edit', $prestamo) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('prestamos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-list"></i> Volver al Listado
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>ID:</strong></p>
                        <p>{{ $prestamo->id }}</p>

                        <p class="mb-1"><strong>Usuario Solicitante:</strong></p>
                        <p>{{ $prestamo->solicitante->name ?? 'N/A' }}</p>

                        <p class="mb-1"><strong>Usuario Receptor:</strong></p>
                        <p>{{ $prestamo->receptor->name ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Fecha Préstamo:</strong></p>
                        <p>{{ $prestamo->fecha_prestamo_formatted }}</p>

                        <p class="mb-1"><strong>Fecha Vencimiento:</strong></p>
                        <p>{{ $prestamo->fecha_vencimiento_formatted }}</p>

                        <p class="mb-1"><strong>Fecha Devolución:</strong></p>
                        <p>{{ $prestamo->fecha_devolucion_formatted }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Estado:</strong></p>
                        <p>
                            <span class="badge rounded-pill
                                @if($prestamo->estado == 'prestado') bg-warning text-dark @endif
                                @if($prestamo->estado == 'devuelto') bg-success @endif
                                @if($prestamo->estado == 'vencido') bg-danger @endif
                            ">
                                {{ ucfirst($prestamo->estado) }}
                            </span>
                        </p>
                        <p class="mb-1"><strong>Activo:</strong></p>
                        <p>
                            @if ($prestamo->is_active)
                                <span class="badge rounded-pill bg-primary">Sí</span>
                            @else
                                <span class="badge rounded-pill bg-secondary">No</span>
                            @endif
                        </p>
                    </div>

                    @if($prestamo->firma_solicitante)
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Firma Solicitante:</strong></p>
                        <pre class="bg-light p-2 rounded" style="max-height: 100px; overflow: auto;">{{ $prestamo->firma_solicitante }}</pre>
                    </div>
                    @endif

                    @if($prestamo->firma_receptor)
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Firma Receptor:</strong></p>
                        <pre class="bg-light p-2 rounded" style="max-height: 100px; overflow: auto;">{{ $prestamo->firma_receptor }}</pre>
                    </div>
                    @endif

                    @if($prestamo->observaciones)
                    <div class="col-12">
                        <p class="mb-1"><strong>Observaciones:</strong></p>
                        <p class="bg-light p-2 rounded">{{ $prestamo->observaciones }}</p>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-footer text-muted">
                <small>Creado: {{ $prestamo->created_at->isoFormat('DD/MM/YYYY HH:mm') }} ({{ $prestamo->created_at->diffForHumans() }})</small><br>
                <small>Última actualización: {{ $prestamo->updated_at->isoFormat('DD/MM/YYYY HH:mm') }} ({{ $prestamo->updated_at->diffForHumans() }})</small>
            </div>
        </div>
    </div>
</x-admin-layout>