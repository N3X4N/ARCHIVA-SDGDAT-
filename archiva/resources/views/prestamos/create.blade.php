<x-admin-layout>
    <x-slot name="title">Crear Nuevo Préstamo</x-slot>

    <div class="container-fluid"> {{-- O solo .container si prefieres ancho fijo --}}
        <h1 class="mb-4">Crear Nuevo Préstamo</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('prestamos.store') }}" method="POST">
            @csrf
            @include('prestamos._form', [
                'prestamo' => null,
                'users' => $users
            ])

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Préstamo
                </button>
                <a href="{{ route('prestamos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>