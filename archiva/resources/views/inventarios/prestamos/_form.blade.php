@php
  // Para la fecha por defecto
  $now = \Carbon\Carbon::now()->format('Y-m-d\TH:i');
@endphp

{{-- 1) Selección de Ítems --}}
<div class="mb-4">
  <h5>Ítems a prestar <span class="text-danger">*</span></h5>
  @foreach($detallesTransferencia as $d)
    <div class="form-check">
      <input
        class="form-check-input"
        type="checkbox"
        name="detalles[]"
        id="detalle-{{ $d->id }}"
        value="{{ $d->id }}"
        {{ in_array($d->id, old('detalles', $selected)) ? 'checked' : '' }}
      >
      <label class="form-check-label" for="detalle-{{ $d->id }}">
        {{ optional($d->serie)->nombre }} /
        {{ optional($d->subserie)->nombre }} —
        Ubic: {{ optional($d->ubicacion)->estante }}
             / {{ optional($d->ubicacion)->bandeja }}
             / {{ optional($d->ubicacion)->caja }}
      </label>
    </div>
  @endforeach
  @error('detalles')
    <div class="text-danger mt-1">{{ $message }}</div>
  @enderror
</div>

{{-- 2) Datos del préstamo --}}
<div class="row g-3 mb-4">
  <div class="col-md-6">
    <label for="user_id_solicitante" class="form-label"><strong>Solicitante <span class="text-danger">*</span></strong></label>
    <select name="user_id_solicitante" id="user_id_solicitante" class="form-select @error('user_id_solicitante') is-invalid @enderror" required>
      <option value="">Seleccione...</option>
      @foreach($users as $id => $nombre)
        <option value="{{ $id }}"
          {{ old('user_id_solicitante') == $id ? 'selected' : '' }}>
          {{ $nombre }}
        </option>
      @endforeach
    </select>
    @error('user_id_solicitante')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6">
    <label for="user_id_receptor" class="form-label"><strong>Receptor</strong></label>
    <select name="user_id_receptor" id="user_id_receptor" class="form-select @error('user_id_receptor') is-invalid @enderror">
      <option value="">— Si aplica —</option>
      @foreach($users as $id => $nombre)
        <option value="{{ $id }}"
          {{ old('user_id_receptor') == $id ? 'selected' : '' }}>
          {{ $nombre }}
        </option>
      @endforeach
    </select>
    @error('user_id_receptor')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-md-6">
    <label for="fecha_prestamo" class="form-label"><strong>Fecha Préstamo <span class="text-danger">*</span></strong></label>
    <input
      type="datetime-local"
      name="fecha_prestamo"
      id="fecha_prestamo"
      class="form-control @error('fecha_prestamo') is-invalid @enderror"
      value="{{ old('fecha_prestamo', $now) }}"
      required
    >
    @error('fecha_prestamo')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6">
    <label for="fecha_vencimiento" class="form-label"><strong>Fecha Vencimiento</strong></label>
    <input
      type="datetime-local"
      name="fecha_vencimiento"
      id="fecha_vencimiento"
      class="form-control @error('fecha_vencimiento') is-invalid @enderror"
      value="{{ old('fecha_vencimiento') }}"
    >
    @error('fecha_vencimiento')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>

{{-- 3) Observaciones y activo --}}
<div class="mb-3">
  <label for="observaciones" class="form-label"><strong>Observaciones</strong></label>
  <textarea
    name="observaciones"
    id="observaciones"
    class="form-control @error('observaciones') is-invalid @enderror"
    rows="3"
  >{{ old('observaciones') }}</textarea>
  @error('observaciones')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<div class="form-check mb-4">
  <input
    class="form-check-input"
    type="checkbox"
    name="is_active"
    id="is_active"
    value="1"
    {{ old('is_active', true) ? 'checked' : '' }}
  >
  <label class="form-check-label" for="is_active">Activo</label>
</div>
