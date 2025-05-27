<x-admin-layout>
    <x-slot name="title">Editar Perfil</x-slot>

    <div class="container">
        <h1 class="mb-4">Editar Perfil</h1>

        @if (session('alertMessage'))
            <div class="alert alert-{{ session('alertType') }}">
                {{ session('alertMessage') }}
            </div>
        @endif

        <form action="{{ route('perfiles.update', $perfil->user_id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $perfil->nombres) }}" required>
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $perfil->apellidos) }}" required>
            </div>

            <div class="mb-3">
                <label for="dependencia_id" class="form-label">Dependencia</label>
                <select name="dependencia_id" class="form-select">
                    <option value="">Seleccione dependencia</option>
                    @foreach ($dependencias as $id => $nombre)
                        <option value="{{ $id }}" {{ $perfil->dependencia_id == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="firma_digital" class="form-label">Firma Digital (imagen/PDF)</label>
                <input type="file" name="firma_digital" class="form-control">

                @if ($perfil->firma_digital)
                    <p class="mt-2">
                        <strong>Archivo actual:</strong>
                        <a href="{{ Storage::url($perfil->firma_digital) }}" target="_blank">Ver Firma Completa</a>
                    </p>
                    @if (Str::endsWith($perfil->firma_digital, ['.jpg', '.jpeg', '.png']))
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $perfil->firma_digital) }}" alt="Firma Digital" style="max-height: 150px;">
                        </div>
                    @else
                        <p><em>El archivo actual no es una imagen visible (es probablemente un PDF).</em></p>
                    @endif
                @endif
            </div>

            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="{{ route('perfiles.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
