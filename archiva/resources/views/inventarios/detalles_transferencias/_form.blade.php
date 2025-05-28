@php
    // Cuando editas, $transferencia existe; si no, es null
    $isEdit = isset($transferencia);
    // Helper para old() o valor del model
    $getHead = fn(string $f) => old($f, $transferencia->$f ?? '');
@endphp

<form method="POST"
    action="{{ $isEdit
        ? route('inventarios.transferencias.update', $transferencia)
        : route('inventarios.transferencias.store') }}">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <br>
    <div class="card text-bg-light mb-3">
        <div class="card-header">Encabezado de Transferencia</div>
        <div class="card-body row g-3">
            {{-- Entidad Remitente --}}
            <div class="col-md-3">
                <label class="form-label"><strong>Entidad Remitente</strong></label>
                <select name="entidad_remitente_id" id="entidad_remitente_id" class="form-select" required>
                    <option value="">Seleccione…</option>
                    @foreach ($dependencias as $id => $nombre)
                        <option value="{{ $id }}" data-dep-codigo="{{ $dependenciasCodigos[$id] }}"
                            {{ $getHead('entidad_remitente_id') == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Entidad Productora --}}
            <div class="col-md-3">
                <label class="form-label"><strong>Entidad Productora</strong></label>
                <select name="entidad_productora_id" class="form-select" required>
                    <option value="">Seleccione…</option>
                    @foreach ($entidadesProductoras as $id => $nombre)
                        <option value="{{ $id }}"
                            {{ $getHead('entidad_productora_id') == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Unidad Administrativa --}}
            <div class="col-md-6">
                <label class="form-label"><strong>Unidad Administrativa</strong></label>
                <input type="text" name="unidad_administrativa" class="form-control" required
                    value="{{ old('unidad_administrativa', $transferencia->unidad_administrativa ?? 'ALCALDIA MUNICIPAL DE TABIO') }}">
            </div>
            {{-- Oficina Productora --}}
            <div class="col-md-3">
                <label class="form-label"><strong>Oficina Productora</strong></label>
                <select name="oficina_productora_id" class="form-select" required>
                    <option value="">Seleccione…</option>
                    @foreach ($oficinasProductoras as $id => $nombre)
                        <option value="{{ $id }}"
                            {{ $getHead('oficina_productora_id') == $id ? 'selected' : '' }}>
                            {{ $nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Objeto --}}
            <div class="col-12">
                <label class="form-label"><strong>Objeto</strong></label>
                <input type="text" name="objeto" class="form-control" value="{{ $getHead('objeto') }}"
                    placeholder="Descripción…">
            </div>

            {{-- Registro de Entrada --}}
            <div class="col-12 text-center"><strong>REGISTRO DE ENTRADA</strong></div>
            <div class="col-md-4">
                <label class="form-label"><strong>AÑO</strong></label>
                <input type="text" class="form-control" value="{{ now()->format('Y') }}" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label"><strong>MES</strong></label>
                <input type="text" class="form-control" value="{{ now()->format('m') }}" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label"><strong>DÍA</strong></label>
                <input type="text" class="form-control" value="{{ now()->format('d') }}" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label"><strong>N° Transferencia</strong></label>
                <p class="form-control-plaintext">
                    {{ $isEdit ? $transferencia->numero_transferencia : '— Se asignará automáticamente —' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Botón para agregar filas --}}
    <div class="row mb-4">
        <div class="col-12">
            <button type="button" class="btn btn-primary" onclick="addRow()">
                Agregar fila
            </button>
        </div>
    </div>

    {{-- Contenedor de filas dinámicas --}}
    <div id="rows-container">
        @if ($isEdit)
            @foreach ($transferencia->detalles as $i => $det)
                @include('inventarios.transferencias._row', ['det' => $det, 'index' => $i])
            @endforeach
        @endif
    </div>

    {{-- Guardar / Cancelar --}}
    <div class="mt-4">
        <button type="submit" class="btn btn-success">
            {{ $isEdit ? 'Actualizar' : 'Guardar' }}
        </button>
        <a href="{{ route('inventarios.transferencias.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </div>
</form>

@push('scripts')
    <script>
        const subseriesData = @json($subseriesGroup);
        const subseriesCodes = @json($subseriesCodes);
        let globalRowIndex = 0;

        window.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.inventario-row').forEach((row, i) => {
                row.querySelector('.numero-orden').value = String(i + 1).padStart(3, '0');
                row.dataset.rowIndex = i;
            });
            globalRowIndex = document.querySelectorAll('.inventario-row').length;
        });

        function getDepCode() {
            return document
                .getElementById('entidad_remitente_id')
                .selectedOptions[0]
                ?.dataset.depCodigo ?? '';
        }

        function addRow() {
            const tpl = document.getElementById('row-template').innerHTML;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = tpl;
            const row = wrapper.firstElementChild;

            row.dataset.rowIndex = globalRowIndex;
            row.querySelector('.numero-orden').value = String(globalRowIndex + 1).padStart(3, '0');

            const dep = getDepCode();
            row.querySelector('.codigo-field').value = dep ? `${dep}.00.00` : '';

            document.getElementById('rows-container').appendChild(row);
            globalRowIndex++;
        }

        function removeRow(btn) {
            btn.closest('.inventario-row').remove();
            reorderRowNumbers();
        }

        function reorderRowNumbers() {
            document.querySelectorAll('.inventario-row').forEach((row, i) => {
                row.querySelector('.numero-orden').value = String(i + 1).padStart(3, '0');
                row.dataset.rowIndex = i;
            });
            globalRowIndex = document.querySelectorAll('.inventario-row').length;
        }

        document.getElementById('rows-container').addEventListener('change', e => {
            const row = e.target.closest('.inventario-row');
            if (!row) return;

            const depCode = getDepCode();
            const serieSelect = row.querySelector('.serie-select');
            const sc = serieSelect.selectedOptions[0]?.dataset.serieCodigo ?? '';

            // Al cambiar Serie: reiniciamos subserie y extras
            if (e.target.matches('.serie-select')) {
                row.querySelector('.codigo-field').value = depCode && sc ? `${depCode}.${sc}.00` : '';
                const cb = row.querySelector('.usa-subserie-checkbox');
                cb.checked = false;
                cb.dispatchEvent(new Event('change'));
            }

            // Al (des)marcar Subserie?
            if (e.target.matches('.usa-subserie-checkbox')) {
                const checked = e.target.checked;
                const subSelect = row.querySelector('.subserie-select');
                const hiddenSub = row.querySelector('.fallback-subserie');

                subSelect.disabled = !checked;
                hiddenSub.disabled = checked;

                if (checked && sc && subseriesData[serieSelect.value]) {
                    subSelect.innerHTML = '<option value="">– Seleccione subserie –</option>' +
                        Object.entries(subseriesData[serieSelect.value])
                        .map(([id, name]) =>
                            `<option value="${id}" data-subserie-codigo="${subseriesCodes[id]||''}">${name}</option>`
                        ).join('');
                }

                const fallbacks = row.querySelectorAll('.subserie-extra-fields .fallback');
                const reals = row.querySelectorAll('.subserie-extra-fields .real');

                if (checked) {
                    fallbacks.forEach(i => i.disabled = true);
                    reals.forEach(i => i.disabled = false);
                } else {
                    reals.forEach(i => i.disabled = true);
                    fallbacks.forEach(i => i.disabled = false);
                    row.querySelector('.codigo-field').value = depCode && sc ? `${depCode}.${sc}.00` : '';
                }
            }

            // Al seleccionar Subserie → actualizar código
            if (e.target.matches('.subserie-select')) {
                const subC = e.target.selectedOptions[0]?.dataset.subserieCodigo ?? '00';
                row.querySelector('.codigo-field').value = `${depCode}.${sc}.${subC}`;
            }
        });

        document.getElementById('entidad_remitente_id')
            .addEventListener('change', reorderRowNumbers);
    </script>
@endpush

<template id="row-template">
    <div class="card border-dark mb-3 inventario-row">
        <div class="card-body">
            <div class="row g-3 align-items-end">

                {{-- detalle_id --}}
                <input type="hidden" name="detalle_id[]" value="">

                {{-- Nº Orden --}}
                <div class="col-6 col-md-2">
                    <label class="form-label">N° Orden</label>
                    <input type="text" name="numero_orden[]" class="form-control numero-orden" readonly>
                </div>

                {{-- Código --}}
                <div class="col-6 col-md-2">
                    <label class="form-label">Código</label>
                    <input type="text" name="codigo[]" class="form-control codigo-field" readonly>
                </div>

                {{-- Serie --}}
                <div class="col-12 col-md-4">
                    <label class="form-label">Serie <span class="text-danger">*</span></label>
                    <select name="serie_documental_id[]" class="form-select serie-select" required>
                        <option value="">– Seleccione serie –</option>
                        @foreach ($seriesList as $sid => $sn)
                            <option value="{{ $sid }}" data-serie-codigo="{{ $seriesCodes[$sid] ?? '' }}">
                                {{ $sn }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Checkbox Subserie --}}
                <div class="col-6 col-md-2 d-flex align-items-center">
                    <div class="form-check mt-3">
                        <input class="form-check-input usa-subserie-checkbox" type="checkbox">
                        <label class="form-check-label">Subserie?</label>
                    </div>
                </div>

                {{-- Subserie --}}
                <div class="col-12 col-md-4">
                    <input type="hidden" name="subserie_documental_id[]" class="fallback fallback-subserie"
                        value="">
                    <label class="form-label">Subserie</label>
                    <select name="subserie_documental_id[]" class="form-select real subserie-select" disabled>
                        <option value="">– Primero activa checkbox –</option>
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
                        <input type="hidden" name="{{ $field }}[]" class="fallback" value="">
                        <label class="form-label">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="{{ $type }}" name="{{ $field }}[]" class="form-control real"
                            min="0" disabled>
                    </div>
                @endforeach

                {{-- Soporte --}}
                <div class="col-6 col-md-2 subserie-extra-fields">
                    <input type="hidden" name="soporte_id[]" class="fallback" value="">
                    <label class="form-label">Soporte</label>
                    <select name="soporte_id[]" class="form-select real" disabled>
                        <option value="">– Seleccione soporte –</option>
                        @foreach ($soportes as $sid => $sn)
                            <option value="{{ $sid }}">{{ $sn }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Ubicación --}}
                <div class="col-md-4 subserie-extra-fields">
                    <input type="hidden" name="ubicacion_id[]" class="fallback" value="">
                    <label class="form-label">Ubicación</label>
                    <select name="ubicacion_id[]" class="form-select real" disabled>
                        <option value="">Seleccione…</option>
                        @foreach ($ubicaciones as $uid => $lbl)
                            <option value="{{ $uid }}">{{ $lbl }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Observaciones --}}
                <div class="col-12 subserie-extra-fields">
                    {{-- fallback para que siempre llegue un valor --}}
                    <input type="hidden" name="observaciones[]" class="fallback" value="">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones[]" class="form-control real" rows="2" disabled></textarea>
                </div>

                {{-- Botón Eliminar --}}
                <div class="col-12 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>
