<x-admin-layout>
    <x-slot name="title">Editar Transferencia #{{ $transferencia->id }}</x-slot>

    <div class="container-fluid">
        <h1>Editar Transferencia #{{ $transferencia->id }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('inventarios.transferencias.update', $transferencia) }}">
            @csrf
            @method('PUT')

            @include('inventarios.transferencias._form')

        </form>
    </div>
</x-admin-layout>
