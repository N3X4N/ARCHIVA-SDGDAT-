{{-- resources/views/inventarios/series/subseries/_form.blade.php --}}
@php
    use Illuminate\Support\Str;

    // Sufijo: lo que viene después de "SERIE-CODIGO-"
    $currentSuffix = old(
        'suffix',
        isset($subseries->codigo) ? Str::after($subseries->codigo, $series->codigo . '-') : '',
    );

    // Estado por defecto
    $active = old('is_active', $subseries->is_active ?? true);
@endphp

<div class="mb-3">
    <label for="codigo" class="form-label">Código de Subserie</label>
    <input type="text" id="codigo" name="codigo" class="form-control @error('codigo') is-invalid @enderror"
        value="{{ old('codigo', $subseries->codigo ?? '') }}">
    @error('codigo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" id="nombre" name="nombre" class="form-control"
        value="{{ old('nombre', $subseries->nombre ?? '') }}">
    @error('nombre')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="dependencias_ids" class="form-label">Dependencias productoras</label>
    <select name="dependencias_ids[]" id="dependencias_ids"
        class="form-select @error('dependencias_ids') is-invalid @enderror" multiple>
        @foreach ($dependencias as $id => $nom)
            <option value="{{ $id }}"
                {{ in_array($id, old('dependencias_ids', $seleccionadas)) ? 'selected' : '' }}>{{ $nom }}
            </option>
        @endforeach
    </select>
    @error('dependencias_ids')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-check form-switch mb-3">
    <input type="hidden" name="is_active" value="0">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
        {{ $active ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>
