<x-admin-layout>
    <x-slot name="title">Nueva Transferencia</x-slot>
    <div class="container-fluid">
        <h1>Crear Transferencia</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('inventarios.transferencias.store') }}">
            @csrf

            @include('inventarios.transferencias._form')

        </form>
    </div>
</x-admin-layout>
