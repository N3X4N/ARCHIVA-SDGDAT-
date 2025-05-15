{{-- resources/views/inventarios/tipos_documentales/_form.blade.php --}}
@php
    // En create $tipo_documental no existe, en edit sí.
    $isEdit = isset($tipo_documental);
@endphp

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text"
           name="nombre"
           class="form-control"
           value="{{ old('nombre', $tipo_documental->nombre ?? '') }}">
    @error('nombre')<small class="text-danger">{{ $message }}</small>@enderror
</div>

<div class="form-check mb-3">
    <input type="checkbox"
           name="is_active"
           value="1"
           class="form-check-input"
           id="is_active"
           {{ old('is_active', $tipo_documental->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>
