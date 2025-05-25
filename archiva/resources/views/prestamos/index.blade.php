<x-admin-layout>
    <x-slot name="title">Listado de Préstamos</x-slot>

    <div class="container-fluid">
        <h1 class="mb-4">Listado de Préstamos</h1>

        <a href="{{ route('prestamos.create') }}" class="btn btn-success mb-3">
            Nuevo Préstamo
        </a>

        <form method="GET" action="{{ route('prestamos.index') }}" class="card card-body mb-4">
            <div class="row gx-2 gy-2">
                <div class="col-md-3">
                    <label for="user_id_solicitante_filter">Solicitante</label>
                    <select name="user_id_solicitante_filter" id="user_id_solicitante_filter" class="form-select form-select-sm">
                        <option value="">Seleccione...</option>
                        @foreach ($usersForFilter as $id => $nombre)
                        <option value="{{ $id }}"
                            {{ request('user_id_solicitante_filter') == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="estado_filter">Estado</label>
                    <select name="estado_filter" id="estado_filter" class="form-select form-select-sm">
                        <option value="">Seleccione...</option>
                        @foreach ($estadosPrestamo as $key => $estadoNombre)
                        <option value="{{ $key }}" {{ request('estado_filter') == $key ? 'selected' : '' }}>
                            {{ $estadoNombre }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="fecha_prestamo_inicio">F. Préstamo Desde</label>
                    <input type="date" name="fecha_prestamo_inicio" id="fecha_prestamo_inicio" class="form-control form-control-sm" value="{{ request('fecha_prestamo_inicio') }}" placeholder="F. Préstamo Desde">
                </div>
                <div class="col-md-3">
                    <label for="fecha_prestamo_fin">F. Préstamo Hasta</label>
                    <input type="date" name="fecha_prestamo_fin" id="fecha_prestamo_fin" class="form-control form-control-sm" value="{{ request('fecha_prestamo_fin') }}" placeholder="F. Préstamo Hasta">
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary mt-3">Aplicar Filtros</button>
                <a href="{{ route('inventarios.transferencias.index') }}" class="btn btn-secondary mt-3">Limpiar
                    Filtros</a>
            </div>
        </form>


        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                @if($prestamos->total() > 0)
                <span>Mostrando {{ $prestamos->firstItem() }} a {{ $prestamos->lastItem() }} de
                    {{ $prestamos->total() }} resultados</span>
                @else
                <span>No se encontraron resultados.</span>
                @endif
            </div>
            <div>
                {{ $prestamos->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped w-100">
                <thead>
                    <tr>
                        <th>Solicitante</th>
                        <th>Receptor</th>
                        <th>Fecha Préstamo</th>
                        <th>Fecha Vencimiento</th>
                        <th>Fecha Devolución</th>
                        <th>Estado</th>
                        <th>Activo</th>
                        <th style="width: 15%;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prestamos as $prestamo)
                    <tr>
                        <td>{{ $prestamo->solicitante->name ?? 'N/A' }}</td>
                        <td>{{ $prestamo->receptor->name ?? 'N/A' }}</td>
                        <td>{{ $prestamo->fecha_prestamo_formatted }}</td>
                        <td>{{ $prestamo->fecha_vencimiento_formatted }}</td>
                        <td>{{ $prestamo->fecha_devolucion_formatted }}</td>
                        <td>
                            @if ($prestamo->estado === 'devuelto')
                            <span class="badge rounded-pill bg-success">devuelto</span>
                            @elseif ($prestamo->estado === 'prestado')
                            <span class="badge rounded-pill bg-warning">prestado</span>
                            @elseif ($prestamo->estado === 'vencido')
                            <span class="badge rounded-pill bg-danger">vencido</span>
                            @endif
                        </td>
                        <td>
                            <i
                                class="fa {{ $prestamo->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                            {{ $prestamo->is_active ? 'Activo' : 'Inactivo' }}
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('prestamos.show', $prestamo) }}" class="btn btn-sm btn-info me-1" title="Ver">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('prestamos.edit', $prestamo) }}" class="btn btn-sm btn-primary mr-2" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="{{ route('prestamos.destroy', $prestamo) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar este prestamo?')" class="d-inline mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No hay préstamos registrados que coincidan con los filtros.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-end">
            {{ $prestamos->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</x-admin-layout>