{{-- resources/views/inventarios/tipos_documentales/index.blade.php --}}
<x-admin-layout>
    <x-slot name="title">Tipos Documentales</x-slot>

    <div class="container-fluid">
        {{-- Cabecera --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Tipos Documentales</h1>
            <a href="{{ route('inventarios.tipos-documentales.create') }}" class="btn btn-success">
                <i class="fa fa-plus me-1"></i> Nuevo Tipo
            </a>
        </div>

        {{-- Formulario de filtros --}}
        <form method="GET" action="{{ route('inventarios.tipos-documentales.index') }}">
            <div class="row g-3 align-items-end">
                {{-- Nombre --}}
                <div class="col-md-3">
                    <label for="search" class="form-label">Nombre</label>
                    <input type="text" id="search" name="search" class="form-control"
                        placeholder="Buscar por nombre" value="{{ request('search') }}">
                </div>

                {{-- Estado --}}
                <div class="col-md-3">
                    <label for="is_active" class="form-label">Estado</label>
                    <select id="is_active" name="is_active" class="form-select">
                        <option value="">Seleccione...</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                {{-- Filtrar --}}
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-filter me-1"></i> Filtrar
                    </button>
                </div>

                {{-- Limpiar filtros --}}
                <div class="col-md-3">
                    <a href="{{ route('inventarios.tipos-documentales.index') }}"
                        class="btn btn-outline-secondary w-100">
                        Limpiar filtros
                    </a>
                </div>
            </div>
        </form>

        <!-- Paginación -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
            <div>
                <small>
                    Mostrando {{ $tipos->firstItem() }} a {{ $tipos->lastItem() }}
                    de {{ $tipos->total() }} resultados
                </small>
            </div>
            <div>
                {{ $tipos->links('pagination::bootstrap-4') }}
            </div>
        </div>

        {{-- Tabla --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tipos as $tipo)
                        <tr>
                            <td>{{ $tipo->nombre }}</td>
                            <td>
                                <i
                                    class="fa {{ $tipo->is_active ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                                {{ $tipo->is_active ? 'Activo' : 'Inactivo' }}
                            </td>
                            <td class="d-flex justify-content-center gap-1">
                                <a href="{{ route('inventarios.tipos-documentales.edit', $tipo) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="fa fa-pen me-1"></i> Editar
                                </a>
                                <form action="{{ route('inventarios.tipos-documentales.destroy', $tipo) }}"
                                    method="POST" class="d-inline js-confirmable"
                                    data-confirm-message="¿Eliminar tipo documental '{{ $tipo->nombre }}'?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No hay tipos documentales.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
