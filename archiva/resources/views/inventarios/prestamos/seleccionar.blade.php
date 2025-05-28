<x-admin-layout>
    <x-slot name="title">1️⃣ Seleccionar Ítems para Préstamo</x-slot>

    <form action="{{ route('prestamos.create') }}" method="GET">
        @csrf

        <div class="mb-3">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-book-reader me-1"></i>
                Siguiente: Datos del Préstamo
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle text-center">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="check-all" /></th>
                        <th>Serie</th>
                        <th>Subserie</th>
                        <th>Ubicación</th>
                        <th>Código</th>
                        <th>Orden</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($detalles as $d)
                        <tr>
                            <td>
                                <input type="checkbox" class="check-item" name="detalles[]"
                                    value="{{ $d->id }}" />
                            </td>
                            <td>{{ optional($d->serie)->nombre }}</td>
                            <td>{{ optional($d->subserie)->nombre }}</td>
                            <td>
                                {{ optional($d->ubicacion)->estante }}
                                / {{ optional($d->ubicacion)->bandeja }}
                                / {{ optional($d->ubicacion)->caja }}
                            </td>
                            <td>{{ $d->codigo }}</td>
                            <td>{{ $d->numero_orden }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay ítems activos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            {{ $detalles->links('pagination::bootstrap-4') }}
        </div>
    </form>

    @push('scripts')
        <script>
            document.getElementById('check-all').addEventListener('change', function() {
                document.querySelectorAll('.check-item').forEach(cb => cb.checked = this.checked);
            });
        </script>
    @endpush
</x-admin-layout>
