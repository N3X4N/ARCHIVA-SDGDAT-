@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>Editar Usuario</h1>

    @if($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
          <label for="roles" class="form-label">Rol(es)</label>
          <select name="roles[]" id="roles" class="form-select" multiple required>
              @foreach($roles as $role)
                  <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                      {{ $role->name }}
                  </option>
              @endforeach
          </select>
          <small class="form-text text-muted">Seleccione uno o más roles.</small>
        </div>

        <!-- Campo opcional para cambiar la contraseña -->
        <div class="mb-3">
          <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Dejar vacío para no cambiar">
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
          <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Dejar vacío para no cambiar">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
@endsection
