<x-admin-layout>
    <x-slot name="title">Inventario Documental</x-slot>

    <!-- Usar container-fluid para que la tabla ocupe todo el ancho disponible -->
    <div class="container-fluid">
        <h1 class="mb-4">Inventario Documental</h1>

        <a href="{{ route('inventarios.transferencias.create') }}" class="btn btn-success mb-3">
            Nueva Transferencia
        </a>

        <!-- Formulario de filtros -->
        <form method="GET" action="{{ route('inventarios.transferencias.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="dependencia_id">Dependencia</label>
                    <select name="dependencia_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach ($dependencias as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ request('dependencia_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="serie_documental_id">Serie Documental</label>
                    <select name="serie_documental_id" class="form-control">
                        <option value="">Seleccione...</option>
                        @foreach ($series as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ request('serie_documental_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="fecha_inicio">Fecha de Registro</label>
                    <input type="date" name="fecha_inicio" class="form-control"
                        value="{{ request('fecha_inicio') }}">
                </div>

                <div class="col-md-3">
                    <label for="fecha_fin">A</label>
                    <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                </div>
            </div>

            <!-- Botón para aplicar filtros -->
            <button type="submit" class="btn btn-primary mt-3">Aplicar Filtros</button>
            <!-- Botón para limpiar filtros -->
            <a href="{{ route('inventarios.transferencias.index') }}" class="btn btn-secondary mt-3">Limpiar
                Filtros</a>
        </form>

           <!-- Paginación -->
           <div class="d-flex justify-content-between align-items-center">
            <div>
                <span>Mostrando {{ $transferencias->firstItem() }} a {{ $transferencias->lastItem() }} de
                    {{ $transferencias->total() }} resultados</span>
            </div>
            <div>
                {{ $transferencias->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

        <!-- Asegurarse de que la tabla sea responsiva y ocupe todo el espacio disponible -->
        <div class="table-responsive">
            <table class="table table-striped w-100"> <!-- La clase w-100 garantiza que la tabla ocupe todo el ancho -->
                <thead>
                    <tr>
                        <th>Código Interno</th>
                        <th>Dependencia</th>
                        <th>Serie</th>
                        <th>Subserie</th>
                        <th>Ubicación</th>
                        <th>Soporte</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transferencias as $t)
                        <tr>
                            <td>{{ $t->codigo_interno }}</td>
                            <td>{{ optional($t->dependencia)->nombre }}</td>
                            <td>{{ optional($t->serieDocumental)->nombre }}</td>
                            <td>{{ optional($t->subserieDocumental)->nombre }}</td>
                            <td>
                                {{ optional($t->ubicacion)->estante .
                                    ' - ' .
                                    optional($t->ubicacion)->bandeja .
                                    ' - ' .
                                    optional($t->ubicacion)->caja .
                                    ' - ' .
                                    optional($t->ubicacion)->carpeta .
                                    ' - ' .
                                    optional($t->ubicacion)->otro }}
                            </td>
                            <td>{{ optional($t->soporte)->nombre }}</td>
                            <td>
                                <!-- Estado con badge y color basado en el valor de estado_flujo -->
                                <span
                                    class="badge {{ $t->estado_flujo == 'disponible' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($t->estado_flujo) }}
                                </span>
                            </td>

                            <td class="d-flex gap-1">
                                <!-- Botón de editar con ícono -->
                                <a href="{{ route('inventarios.transferencias.edit', $t) }}"
                                    class="btn btn-sm btn-primary" title="Editar">
                                    <i class="fa-solid fa-pen"></i> Editar
                                </a>

                                <!-- Formulario para borrar con confirmación -->
                                <form action="{{ route('inventarios.transferencias.destroy', $t) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar esta transferencia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Borrar">
                                        <i class="fa-solid fa-trash"></i> Borrar
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No hay transferencias registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
</x-admin-layout>
