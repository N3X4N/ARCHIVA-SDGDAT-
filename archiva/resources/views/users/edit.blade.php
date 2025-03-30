<!-- resources/views/users/edit.blade.php -->
<x-admin-layout>
    <x-slot name="title">
        Editar Usuario
    </x-slot>

    <div class="container">
        <h1 class="mb-4">Editar Usuario: {{ $user->name }}</h1>
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="form-control" required>
            </div>

            <!-- Campo opcional para cambiar contraseña -->
            <div class="form-group">
                <label for="password">Contraseña (dejar en blanco para no modificar):</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <!-- Selección de Roles -->
            <div class="form-group">
                <label for="roles">Roles:</label>
                <select name="roles[]" id="roles" class="form-control" multiple>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" @if (in_array($role->name, $user->getRoleNames()->toArray())) selected @endif>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Mantén presionada la tecla Ctrl (Cmd en Mac) para seleccionar
                    múltiples roles.</small>
            </div>

            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</x-admin-layout>
