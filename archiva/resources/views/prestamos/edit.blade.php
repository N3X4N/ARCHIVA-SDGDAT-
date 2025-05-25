<x-admin-layout>
    <x-slot name="title">Editar Préstamo #{{ $prestamo->id }}</x-slot>

    <div class="container-fluid">
        <h1 class="mb-4">Editar Préstamo #{{ $prestamo->id }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('prestamos.update', $prestamo) }}" method="POST">
            @csrf
            @method('PUT')
            @include('prestamos._form', [
                'prestamo' => $prestamo,
                'users' => $users
            ])

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Actualizar Préstamo
                </button>
                <a href="{{ route('prestamos.index') }}" class="btn btn-secondary">
                     <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</x-admin-layout>