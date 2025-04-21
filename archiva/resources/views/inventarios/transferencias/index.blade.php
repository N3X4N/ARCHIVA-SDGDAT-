<x-admin-layout>
    <x-slot name="title">Inventario Documental</x-slot>

    <div class="container">
        <h1 class="mb-4">Inventario Documental</h1>

        <a href="{{ route('inventarios.transferencias.create') }}" class="btn btn-success mb-3">
            Nueva Transferencia
        </a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
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
                        <td>{{ $t->id }}</td>
                        <td>{{ $t->codigo_interno }}</td>
                        <td>{{ optional($t->dependencia)->nombre }}</td>
                        <td>{{ optional($t->serieDocumental)->nombre }}</td>
                        <td>{{ optional($t->subserieDocumental)->nombre }}</td>
                        <td>{{ optional($t->ubicacion)->nombre }}</td>
                        <td>{{ optional($t->soporte)->nombre }}</td>
                        <td>
                            <span class="badge {{ $t->estado_flujo == 'disponible' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($t->estado_flujo) }}
                            </span>
                        </td>
                        <td class="d-flex gap-1">
                            <a href="{{ route('inventarios.transferencias.edit', $t) }}"
                                class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('inventarios.transferencias.destroy', $t) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar esta transferencia?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
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

        {{ $transferencias->links() }}
    </div>
</x-admin-layout>
