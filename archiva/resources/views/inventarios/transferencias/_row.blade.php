@php
    $sid = old("serie_documental_id.$index", $det->serie_documental_id ?? '');
    $subId = old("subserie_documental_id.$index", $det->subserie_documental_id ?? '');
    $oldUbic = old("ubicacion_id.$index", $det->ubicacion_id ?? '');
    $oldSoporte = old("soporte_id.$index", $det->soporte_id ?? '');
    $oldObs = old("observaciones.$index", $det->observaciones ?? '');
@endphp

<div class="card border-secondary mb-3 inventario-row" data-row-index="{{ $index }}">
    <div class="card-body">
        <div class="row g-3 align-items-end">

            {{-- ID detalle --}}
            <input type="hidden" name="detalle_id[]" value="{{ $det->id }}">

            {{-- Nº Orden --}}
            <div class="col-6 col-md-2">
                <label class="form-label">N° Orden</label>
                <input type="text" name="numero_orden[]" class="form-control numero-orden" readonly
                    value="{{ old("numero_orden.$index", $det->numero_orden) }}">
            </div>

            {{-- Código --}}
            <div class="col-6 col-md-2">
                <label class="form-label">Código</label>
                <input type="text" name="codigo[]" class="form-control codigo-field" readonly
                    value="{{ old("codigo.$index", $det->codigo) }}">
            </div>

            {{-- Serie --}}
            <div class="col-12 col-md-4">
                <label class="form-label">Serie <span class="text-danger">*</span></label>
                <select name="serie_documental_id[]" class="form-select serie-select" required>
                    <option value="">– Seleccione serie –</option>
                    @foreach ($seriesList as $serieId => $serieName)
                        <option value="{{ $serieId }}" data-serie-codigo="{{ $seriesCodes[$serieId] ?? '' }}"
                            {{ $sid == $serieId ? 'selected' : '' }}>{{ $serieName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Checkbox Subserie --}}
            <div class="col-6 col-md-2 d-flex align-items-center">
                <div class="form-check mt-3">
                    <input class="form-check-input usa-subserie-checkbox" type="checkbox"
                        id="usa-sub-{{ $index }}" {{ $subId ? 'checked' : '' }}>
                    <label class="form-check-label" for="usa-sub-{{ $index }}">
                        Subserie?
                    </label>
                </div>
            </div>

            {{-- Subserie --}}
            <div class="col-12 col-md-4">
                {{-- fallback --}}
                <input type="hidden" name="subserie_documental_id[]" class="fallback fallback-subserie"
                    value="{{ $subId }}" {{ $subId ? 'disabled' : '' }}>
                <label class="form-label">Subserie</label>
                <select name="subserie_documental_id[]" class="form-select real subserie-select"
                    {{ $subId ? '' : 'disabled' }}>
                    <option value="">– Seleccione subserie –</option>
                    @if ($sid && isset($subseriesGroup[$sid]))
                        @foreach ($subseriesGroup[$sid] as $ssid => $sname)
                            <option value="{{ $ssid }}"
                                data-subserie-codigo="{{ $subseriesCodes[$ssid] ?? '' }}"
                                {{ $subId == $ssid ? 'selected' : '' }}>{{ $sname }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            {{-- Campos extras --}}
            @foreach ([
        'fecha_inicial' => 'date',
        'fecha_final' => 'date',
        'caja' => 'number',
        'carpeta' => 'number',
        'resolucion' => 'number',
        'tomo' => 'number',
        'numero_folios' => 'number',
    ] as $field => $type)
                <div class="col-6 col-md-2 subserie-extra-fields">
                    <input type="hidden" name="{{ $field }}[]" class="fallback"
                        value="{{ old("$field.$index", $det->$field) }}" {{ $subId ? 'disabled' : '' }}>
                    <label class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                    <input type="{{ $type }}" name="{{ $field }}[]" class="form-control real"
                        value="{{ old("$field.$index", $det->$field) }}" min="0"
                        {{ $subId ? '' : 'disabled' }}>
                </div>
            @endforeach

            {{-- Soporte --}}
            <div class="col-6 col-md-2 subserie-extra-fields">
                <input type="hidden" name="soporte_id[]" class="fallback" value="{{ $oldSoporte }}"
                    {{ $subId ? 'disabled' : '' }}>
                <label class="form-label">Soporte</label>
                <select name="soporte_id[]" class="form-select real" {{ $subId ? '' : 'disabled' }}>
                    <option value="">– Seleccione soporte –</option>
                    @foreach ($soportes as $soId => $soName)
                        <option value="{{ $soId }}" {{ $oldSoporte == $soId ? 'selected' : '' }}>
                            {{ $soName }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Ubicación --}}
            <div class="col-md-4 subserie-extra-fields">
                <input type="hidden" name="ubicacion_id[]" class="fallback" value="{{ $oldUbic }}"
                    {{ $subId ? 'disabled' : '' }}>
                <label class="form-label">Ubicación</label>
                <select name="ubicacion_id[]" class="form-select real" {{ $subId ? '' : 'disabled' }}>
                    <option value="">Seleccione…</option>
                    @foreach ($ubicaciones as $uid => $lbl)
                        <option value="{{ $uid }}" {{ $oldUbic == $uid ? 'selected' : '' }}>
                            {{ $lbl }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Observaciones --}}
            <div class="col-12 subserie-extra-fields">
                <input type="hidden" name="observaciones[]" class="fallback" value="{{ $oldObs }}"
                    {{ $subId ? 'disabled' : '' }}>
                <label class="form-label">Observaciones</label>
                <textarea name="observaciones[]" class="form-control real" rows="2" {{ $subId ? '' : 'disabled' }}>{{ $oldObs }}</textarea>
            </div>

            {{-- Estado (opcional hidden o select) --}}
            {{-- puedes añadir aquí: <input type="hidden" name="estado_flujo[]" value="{{ old(...,$det->estado_flujo) }}"> --}}

            {{-- Botón Eliminar --}}
            <div class="col-12 text-end">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </div>

        </div>
    </div>
</div>
