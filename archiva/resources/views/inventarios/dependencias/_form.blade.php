@php
    // Por defecto, al crear ($dependencia no existe) queremos is_active = true
    $get = fn($f) => old($f, isset($dependencia) ? $dependencia->$f : null);
    $defaultActive = old('is_active', isset($dependencia) ? $dependencia->is_active : true);
@endphp

<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input name="nombre" value="{{ strtoupper($get('nombre')) }}" class="form-control">
    @error('nombre')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Sigla</label>
    <input name="sigla" value="{{ strtoupper($get('sigla')) }}" class="form-control" maxlength="3">
    @error('sigla')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Código</label>
    <input name="codigo" value="{{ $get('codigo') }}" class="form-control">
    @error('codigo')
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
