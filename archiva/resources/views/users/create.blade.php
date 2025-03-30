@extends('layouts.admin') {{-- Asumiendo que tienes un layout para el área de administración --}}

@section('content')
<div class="container mt-4">
    <h1>Crear Usuario</h1>

    @if($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" name="name" class="form-control" id="name" placeholder="Ingrese nombre" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" name="email" class="form-control" id="email" placeholder="Ingrese email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Contraseña</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Ingrese contraseña" required>
        </div>

        <div class="mb-3">
          <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
          <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirme contraseña" required>
        </div>

        <div class="mb-3">
          <label for="roles" class="form-label">Rol(es)</label>
          <select name="roles[]" id="roles" class="form-select" multiple required>
              @foreach($roles as $role)
                  <option value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach
          </select>
          <small class="form-text text-muted">Seleccione uno o más roles.</small>
        </div>

        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
</div>
@endsection
