{{-- resources/views/inventarios/series/_form.blade.php --}}
@php
    $get = fn($f) => old($f, $series->$f ?? null);
    $active = old('is_active', $series->is_active ?? true);
@endphp

<div class="mb-3">
    <label class="form-label">Código</label>
    <input name="codigo" class="form-control" value="{{ $get('codigo') }}">
    @error('codigo')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input name="nombre" class="form-control" value="{{ $get('nombre') }}">
    @error('nombre')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Tipos Documentales <span class="text-danger">*</span></label>
    <select name="tipos_documentales_ids[]" multiple class="form-select">
        @foreach ($tipos as $id => $nombre)
            <option value="{{ $id }}" {{ in_array($id, $seleccionados) ? 'selected' : '' }}>
                {{ $nombre }}
            </option>
        @endforeach
    </select>
    @error('tipos_documentales_ids')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Observaciones</label>
    <textarea name="observaciones" class="form-control" rows="3">{{ $get('observaciones') }}</textarea>
</div>

<div class="form-check form-switch mb-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
        {{ $active ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>
