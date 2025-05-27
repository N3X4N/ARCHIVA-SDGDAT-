<!-- resources/views/admin/users/_form.blade.php -->
@php
    $get = fn($field) => old($field, isset($user) ? $user->$field : null);
    $defaultActive = old('is_active', isset($dependencia) ? $dependencia->is_active : true);
@endphp

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input name="name" value="{{ $get('name') }}" class="form-control">
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="dependencia_id" class="form-label">Dependencia</label>
    <select name="dependencia_id" id="dependencia_id" class="form-select">
      <option value="">-- Ninguna --</option>
      @foreach($dependencias as $id=>$nombre)
        <option value="{{ $id }}" {{ $get('dependencia_id')==$id?'selected':'' }}>
          {{ $nombre }}
        </option>
      @endforeach
    </select>
  </div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input name="email" type="email" value="{{ $get('email') }}" class="form-control">
    @error('email')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">
        Contraseña
        @if (request()->routeIs('admin.users.edit'))
            <small>(opcional)</small>
        @endif
    </label>
    <input name="password" type="password" class="form-control">
    @error('password')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Confirmar Contraseña</label>
    <input name="password_confirmation" type="password" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Rol</label>
    <select name="role_id" class="form-select">
        @foreach ($roles as $id => $label)
            <option value="{{ $id }}" {{ $get('role_id') == $id ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('role_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-check form-switch mb-3">
    {{-- Para enviar 0 cuando esté desmarcado --}}
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
        {{ $defaultActive ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>
