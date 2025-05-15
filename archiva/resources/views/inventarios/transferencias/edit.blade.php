{{-- resources/views/inventarios/transferencias/edit.blade.php --}}
<x-admin-layout>
    <x-slot name="title">Editar Transferencia Documental</x-slot>

    <div class="container">
        <h1 class="mb-4">Editar Transferencia #{{ $transferencia->numero_transferencia }}</h1>

        <form action="{{ route('inventarios.transferencias.update', $transferencia) }}" method="POST">
            @csrf
            @method('PUT')  {{-- ← Importante --}}
            @include('inventarios.transferencias._form', [
                'transferencia'      => $transferencia,
                'nextTransferNumber' => $transferencia->numero_transferencia, // para que el input siga readonly
            ])

            <button type="submit" class="btn btn-success">Actualizar</button>
            <a href="{{ route('inventarios.transferencias.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
