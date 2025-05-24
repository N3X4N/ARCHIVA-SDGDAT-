{{-- resources/views/inventarios/soportes/_form.blade.php --}}
@php
    $get = fn($f) => old($f, $soporte->$f ?? '');
    $defaultActive = old('is_active', $soporte->is_active ?? true);
@endphp

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input name="nombre" value="{{ $get('nombre') }}" class="form-control">
    @error('nombre')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control" rows="3">{{ $get('descripcion') }}</textarea>
    @error('descripcion')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-check form-switch mb-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
        {{ $defaultActive ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>
