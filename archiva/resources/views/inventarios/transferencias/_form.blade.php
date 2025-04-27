<!-- resources/views/inventarios/transferencias/_form.blade.php -->

<div class="row">
    <!-- Dependencia -->
    <div class="col-md-4">
        <label for="dependencia_id">Dependencia</label>
        <select name="dependencia_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach ($dependencias as $id => $nombre)
                <option value="{{ $id }}" {{ old('dependencia_id', $transferencia->dependencia_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Serie Documental -->
    <div class="col-md-4">
        <label for="serie_documental_id">Serie Documental</label>
        <select name="serie_documental_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach ($series as $id => $nombre)
                <option value="{{ $id }}" {{ old('serie_documental_id', $transferencia->serie_documental_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Subserie Documental -->
    <div class="col-md-4">
        <label for="subserie_documental_id">Subserie Documental</label>
        <select name="subserie_documental_id" class="form-control">
            <option value="">Seleccione...</option>
            @foreach ($subseries as $id => $nombre)
                <option value="{{ $id }}" {{ old('subserie_documental_id', $transferencia->subserie_documental_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <!-- Ubicación -->
    <div class="col-md-4">
        <label for="ubicacion_id">Ubicación</label>
        <select name="ubicacion_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach ($ubicaciones as $id => $estante)
                <option value="{{ $id }}" {{ old('ubicacion_id', $transferencia->ubicacion_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $estante }} - {{ optional($transferencia->ubicacion)->bandeja ?? '' }} - {{ optional($transferencia->ubicacion)->caja ?? '' }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Código Interno -->
    <div class="col-md-4">
        <label for="codigo_interno">Código Interno</label>
        <input type="text" name="codigo_interno" class="form-control" value="{{ old('codigo_interno', $transferencia->codigo_interno ?? '') }}" required>
    </div>

    <!-- Soporte -->
    <div class="col-md-4">
        <label for="soporte_id">Soporte</label>
        <select name="soporte_id" class="form-control" required>
            <option value="">Seleccione...</option>
            @foreach ($soportes as $id => $nombre)
                <option value="{{ $id }}" {{ old('soporte_id', $transferencia->soporte_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <!-- Fecha Extrema Inicial -->
    <div class="col-md-4">
        <label for="fecha_extrema_inicial">Fecha Extrema Inicial</label>
        <input type="date" name="fecha_extrema_inicial" class="form-control" value="{{ old('fecha_extrema_inicial', $transferencia->fecha_extrema_inicial ?? '') }}">
    </div>

    <!-- Fecha Extrema Final -->
    <div class="col-md-4">
        <label for="fecha_extrema_final">Fecha Extrema Final</label>
        <input type="date" name="fecha_extrema_final" class="form-control" value="{{ old('fecha_extrema_final', $transferencia->fecha_extrema_final ?? '') }}">
    </div>

    <!-- Estado de Flujo -->
    <div class="col-md-4">
        <label for="estado_flujo">Estado de Flujo</label>
        <select name="estado_flujo" class="form-control" required>
            <option value="">Seleccione...</option>
            <option value="disponible" {{ old('estado_flujo', $transferencia->estado_flujo ?? '') == 'disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="prestado" {{ old('estado_flujo', $transferencia->estado_flujo ?? '') == 'prestado' ? 'selected' : '' }}>Prestado</option>
        </select>
    </div>
</div>

<div class="row">
    <!-- Número de Folios -->
    <div class="col-md-4">
        <label for="numero_folios">Número de Folios</label>
        <input type="number" name="numero_folios" class="form-control" value="{{ old('numero_folios', $transferencia->numero_folios ?? '') }}">
    </div>

    <!-- Observaciones -->
    <div class="col-md-4">
        <label for="observaciones">Observaciones</label>
        <textarea name="observaciones" class="form-control">{{ old('observaciones', $transferencia->observaciones ?? '') }}</textarea>
    </div>
</div>
