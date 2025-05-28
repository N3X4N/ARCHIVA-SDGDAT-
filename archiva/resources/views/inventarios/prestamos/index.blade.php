<x-admin-layout>
    <x-slot name="title">Listado de Préstamos</x-slot>

    <div class="container-fluid">
        <h1 class="mb-4">Listado de Préstamos</h1>

        <a href="{{ route('inventarios.prestamos.create') }}" class="btn btn-success mb-3">
            Nuevo Préstamo
        </a>

        <form method="GET" action="{{ route('inventarios.prestamos.index') }}" class="card card-body mb-4">
            <div class="row gx-2 gy-2">
                <div class="col-md-3">
                    <label for="user_id_solicitante_filter">Solicitante</label>
                    <select name="user_id_solicitante_filter" id="user_id_solicitante_filter"
                        class="form-select form-select-sm">
                        <option value="">— Todos —</option>
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
                        <option value="">— Todos —</option>
                        @foreach ($estadosPrestamo as $key => $estadoNombre)
                            <option value="{{ $key }}"
                                {{ request('estado_filter') == $key ? 'selected' : '' }}>
                                {{ $estadoNombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="fecha_prestamo_inicio">F. Préstamo Desde</label>
                    <input type="date" name="fecha_prestamo_inicio" id="fecha_prestamo_inicio"
                        class="form-control form-control-sm" value="{{ request('fecha_prestamo_inicio') }}">
                </div>

                <div class="col-md-3">
                    <label for="fecha_prestamo_fin">F. Préstamo Hasta</label>
                    <input type="date" name="fecha_prestamo_fin" id="fecha_prestamo_fin"
                        class="form-control form-control-sm" value="{{ request('fecha_prestamo_fin') }}">
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                <a href="{{ route('inventarios.prestamos.index') }}" class="btn btn-secondary">Limpiar Filtros</a>
            </div>
        </form>

        @if (session('alertMessage'))
            <div class="alert alert-{{ session('alertType') }} alert-dismissible fade show" role="alert">
                {{ session('alertMessage') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                @if ($prestamos->total() > 0)
                    Mostrando {{ $prestamos->firstItem() }}–{{ $prestamos->lastItem() }} de {{ $prestamos->total() }}
                @else
                    No se encontraron resultados.
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
                        <th>F. Préstamo</th>
                        <th>F. Vencimiento</th>
                        <th>F. Devolución</th>
                        <th>Detalles</th>
                        <th>Estado</th>
                        <th>Activo</th>
                        <th style="width: 15%;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prestamos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->solicitante->full_name ?? 'N/A' }}</td>
                            <td>{{ $prestamo->receptor->full_name ?? 'N/A' }}</td>
                            <td>{{ $prestamo->fecha_prestamo_formatted }}</td>
                            <td>{{ $prestamo->fecha_vencimiento_formatted }}</td>
                            <td>{{ $prestamo->fecha_devolucion_formatted }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($prestamo->detallesPrestamo as $item)
                                        <li>
                                            {{ $item->detalleTransferencia->serie->nombre }}
                                            / {{ $item->detalleTransferencia->subserie->nombre }}
                                            (Ubic: {{ $item->detalleTransferencia->ubicacion->nombre }})
                                            — Cant: {{ $item->cantidad }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                @if ($prestamo->estado === 'devuelto')
                                    <span class="badge rounded-pill bg-success">Devuelto</span>
                                @elseif ($prestamo->estado === 'prestado')
                                    <span class="badge rounded-pill bg-warning">Prestado</span>
                                @elseif ($prestamo->estado === 'vencido')
                                    <span class="badge rounded-pill bg-danger">Vencido</span>
                                @endif
                            </td>
                            <td>
                                <i
                                    class="fa {{ $prestamo->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}
                                "></i>
                                {{ $prestamo->is_active ? 'Activo' : 'Inactivo' }}
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('inventarios.prestamos.show', $prestamo) }}"
                                        class="btn btn-sm btn-info me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('inventarios.prestamos.edit', $prestamo) }}"
                                        class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('inventarios.prestamos.destroy', $prestamo) }}" method="POST"
                                        onsubmit="return confirm('¿Eliminar este préstamo?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay préstamos registrados.</td>
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
