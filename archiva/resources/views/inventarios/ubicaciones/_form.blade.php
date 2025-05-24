@php
    // Helper para rellenar old() o el modelo
    $get = fn($f) => old($f, $ubicacion->$f ?? '');
    $defaultActive = old('is_active', $ubicacion->is_active ?? true);
@endphp

<div class="mb-3">
    <label class="form-label">Estante</label>
    <input name="estante" value="{{ $get('estante') }}" class="form-control">
    @error('estante')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Bandeja</label>
    <input name="bandeja" value="{{ $get('bandeja') }}" class="form-control">
    @error('bandeja')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Caja</label>
    <input name="caja" value="{{ $get('caja') }}" class="form-control">
    @error('caja')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Carpeta</label>
    <input name="carpeta" value="{{ $get('carpeta') }}" class="form-control">
    @error('carpeta')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Otro</label>
    <input name="otro" value="{{ $get('otro') }}" class="form-control">
    @error('otro')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-check form-switch mb-3">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
        {{ $defaultActive ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Activo</label>
</div>
