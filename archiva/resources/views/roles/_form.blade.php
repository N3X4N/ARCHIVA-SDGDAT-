@php
    $get = fn($field) => old($field, isset($role) ? $role->$field : null);
    $defaultActive = old('is_active', isset($role) ? $role->is_active : true);
@endphp

<div class="mb-3">
    <label class="form-label">Nombre del Rol</label>
    <input name="nombre_rol" value="{{ $get('nombre_rol') }}" class="form-control">
    @error('nombre_rol')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="description" class="form-control">{{ $get('description') }}</textarea>
    @error('description')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-check form-switch mb-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
        {{ $defaultActive ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>
