@php
  $get = fn($campo) => old($campo, $transferencia->$campo ?? '');
@endphp

<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Dependencia</label>
    <select name="dependencia_id" class="form-select" required>
      <option value="">Seleccione...</option>
      @foreach($dependencias as $id => $nombre)
        <option value="{{ $id }}" {{ $get('dependencia_id') == $id ? 'selected' : '' }}>
          {{ $nombre }}
        </option>
      @endforeach
    </select>
    @error('dependencia_id') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Serie</label>
    <select name="serie_documental_id" class="form-select" required>
      <option value="">Seleccione...</option>
      @foreach($series as $id => $nombre)
        <option value="{{ $id }}" {{ $get('serie_documental_id') == $id ? 'selected' : '' }}>
          {{ $nombre }}
        </option>
      @endforeach
    </select>
    @error('serie_documental_id') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Subserie</label>
    <select name="subserie_documental_id" class="form-select">
      <option value="">Seleccione...</option>
      @foreach($subseries as $id => $nombre)
        <option value="{{ $id }}" {{ $get('subserie_documental_id') == $id ? 'selected' : '' }}>
          {{ $nombre }}
        </option>
      @endforeach
    </select>
    @error('subserie_documental_id') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Ubicación</label>
    <select name="ubicacion_id" class="form-select" required>
      <option value="">Seleccione...</option>
      @foreach($ubicaciones as $id => $nombre)
        <option value="{{ $id }}" {{ $get('ubicacion_id') == $id ? 'selected' : '' }}>
          {{ $nombre }}
        </option>
      @endforeach
    </select>
    @error('ubicacion_id') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Soporte</label>
    <select name="soporte_id" class="form-select" required>
      <option value="">Seleccione...</option>
      @foreach($soportes as $id => $nombre)
        <option value="{{ $id }}" {{ $get('soporte_id') == $id ? 'selected' : '' }}>
          {{ $nombre }}
        </option>
      @endforeach
    </select>
    @error('soporte_id') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Código Interno</label>
    <input type="text" name="codigo_interno" class="form-control" value="{{ $get('codigo_interno') }}" required>
    @error('codigo_interno') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Objeto</label>
    <input type="text" name="objeto" class="form-control" value="{{ $get('objeto') }}">
    @error('objeto') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Fecha Entrada</label>
    <input type="date" name="registro_entrada" class="form-control" value="{{ $get('registro_entrada') }}">
    @error('registro_entrada') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="col-md-6">
    <label class="form-label">Fecha Extrema Inicial</label>
    <input type="date" name="fecha_extrema_inicial" class="form-control" value="{{ $get('fecha_extrema_inicial') }}">
  </div>

  <div class="col-md-6">
    <label class="form-label">Fecha Extrema Final</label>
    <input type="date" name="fecha_extrema_final" class="form-control" value="{{ $get('fecha_extrema_final') }}">
  </div>

  <div class="col-md-6">
    <label class="form-label">Número Folios</label>
    <input type="number" name="numero_folios" class="form-control" value="{{ $get('numero_folios') }}">
  </div>

  <div class="col-md-12">
    <label class="form-label">Observaciones</label>
    <textarea name="observaciones" class="form-control">{{ $get('observaciones') }}</textarea>
  </div>
</div>
