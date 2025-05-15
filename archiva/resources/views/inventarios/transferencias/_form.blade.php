<!-- Formato de Inventario Documental -->
<!-- Formato de Inventario Documental -->
<div class="mt-5">
    <h2 class="mb-4">Formato de Inventario Documental</h2>

    <div class="excel-format">
        <div class="container">

            {{-- ----- Fila 1: Entidad Remitente, Entidad Productora, Oficina Productora, Objeto ----- --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-3">
                    <label for="dependencia_id" class="form-label"><strong>Entidad Remitente</strong></label>
                    <select name="dependencia_id" id="dependencia_id" class="form-select" required>
                        <option value="">Seleccione...</option>
                        @foreach ($dependencias as $id => $nombre)
                            @php $dep = \App\Models\Dependencia::find($id); @endphp
                            <option value="{{ $id }}" data-dep-codigo="{{ $dep->codigo }}"
                                {{ old('dependencia_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label for="entidad_productora_id" class="form-label"><strong>Entidad Productora</strong></label>
                    <select name="entidad_productora_id" id="entidad_productora_id" class="form-select" required>
                        <option value="">Seleccione...</option>
                        @foreach ($entidadesProductoras as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ old('entidad_productora_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6">
                    <label for="unidad_administrativa" class="form-label"><strong>Unidad Administrativa</strong></label>
                    <input type="text" name="unidad_administrativa" id="unidad_administrativa" class="form-control"
                        value="{{ old('unidad_administrativa', 'ALCALDÍA MUNICIPAL DE TABIO') }}" required />
                </div>

                <div class="col-12 col-md-3">
                    <label for="oficina_productora_id" class="form-label"><strong>Oficina Productora</strong></label>
                    <select name="oficina_productora_id" id="oficina_productora_id" class="form-select" required>
                        <option value="">Seleccione...</option>
                        @foreach ($oficinasProductoras as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ old('oficina_productora_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-12">
                    <label for="objeto" class="form-label"><strong>Objeto</strong></label>
                    <input type="text" name="objeto" id="objeto" class="form-control"
                        value="{{ old('objeto') }}" placeholder="Descripción del objeto…" />
                </div>
            </div>

            {{-- ----- Fila 2: Registro de Entrada (centrado) ----- --}}
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <strong>REGISTRO DE ENTRADA</strong>
                </div>
            </div>

            {{-- ----- Fila 3: Año, Mes, Día ----- --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <label class="form-label"><strong>AÑO</strong></label>
                    <input type="text" name="fecha_extrema_inicial" class="form-control"
                        value="{{ old('fecha_extrema_inicial', now()->format('Y')) }}" readonly>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label"><strong>MES</strong></label>
                    <input type="text" name="fecha_extrema_final" class="form-control"
                        value="{{ old('fecha_extrema_final', now()->format('m')) }}" readonly>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label"><strong>DÍA</strong></label>
                    <input type="text" name="dia_creacion" class="form-control"
                        value="{{ old('dia_creacion', now()->format('d')) }}" readonly>
                </div>
            </div>

            {{-- ----- Fila 4: Número de Transferencia ----- --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <label for="numero_transferencia" class="form-label"><strong>N° T</strong></label>
                    <input type="text" name="numero_transferencia" id="numero_transferencia" class="form-control"
                        value="{{ old('numero_transferencia', $nextTransferNumber) }}" readonly required>
                </div>
            </div>

            {{-- ----- Fila 5: Botón Agregar Fila ----- --}}
            <div class="row mb-4">
                <div class="col-12">
                    <button type="button" class="btn btn-primary" onclick="addRow()">Agregar fila</button>
                </div>
            </div>

            <!-- Aquí agregarás las filas de información para las series y subseries -->
            <div id="rows-container">
                <!-- Las filas se agregarán aquí -->
            </div>


        </div>
    </div>
</div>

<script>
    /* ========== Añadir fila ========== */
    function addRow() {
        const container = document.getElementById('rows-container');

        container.insertAdjacentHTML('beforeend', `
            <div class="row g-3 align-items-end mb-4 inventario-row">
                <div class="col-6 col-md-2">
                    <label class="form-label">N° Orden</label>
                    <input type="text" name="numero_orden[]" class="form-control numero-orden" readonly>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Código</label>
                    <input type="text" name="codigo[]" class="form-control codigo-field" readonly>
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">Serie</label>
                    <select name="serie_documental_id[]" class="form-select serie-select">
                    <option value="">– Seleccione serie –</option>
                    @foreach ($seriesList as $sId => $sNombre)
                        <option value="{{ $sId }}"
                                data-serie-codigo="{{ $seriesCodes[$sId] }}">
                        {{ $sNombre }}
                        </option>
                    @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-2 d-flex align-items-center">
                    <div class="form-check mt-3">
                    <input class="form-check-input usa-subserie-checkbox" type="checkbox">
                    <label class="form-check-label">Subserie?</label>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">Subserie</label>
                    <select name="subserie_documental_id[]" class="form-select subserie-select" disabled>
                    <option value="">– Primero activa checkbox –</option>
                    </select>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Fecha Inicial</label>
                    <input type="date" name="fecha_inicial[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Fecha Final</label>
                    <input type="date" name="fecha_final[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Caja</label>
                    <input type="number" name="caja[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Carpeta</label>
                    <input type="number" name="carpeta[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Resolución</label>
                    <input type="number" name="resolucion[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Tomo</label>
                    <input type="number" name="tomo[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Otro</label>
                    <input type="number" name="otro[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Folios</label>
                    <input type="number" name="numero_folios[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Soporte</label>
                    <input type="text" name="soporte[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Ubicación Caja</label>
                    <input type="text" name="ubicacion_caja[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Ubic. Bandeja</label>
                    <input type="text" name="ubicacion_bandeja[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Ubic. Estante</label>
                    <input type="text" name="ubicacion_estante[]" class="form-control">
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Observaciones</label>
                    <input type="text" name="observaciones[]" class="form-control">
                </div>

                <div class="col-auto ms-auto">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeRow(this)">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </div>
            </div>
            <hr>
        `);

        actualizarOrdenes(); // numera después de añadir
    }

    /* ========== Quitar fila ========== */
    function removeRow(btn) {
        const fila = btn.closest('.inventario-row'); // fila a eliminar
        const hr = fila.nextElementSibling; // línea divisora

        fila.remove();
        if (hr && hr.tagName === 'HR') hr.remove();

        actualizarOrdenes(); // re‑numera después de borrar
    }

    /* ========== Recalcular N° Orden ========== */
    function actualizarOrdenes() {
        document
            .querySelectorAll('#rows-container .inventario-row')
            .forEach((row, idx) => {
                row.querySelector('.numero-orden').value = idx + 1;
            });
    }

    const subseriesData = @json($subseriesGroup);
    const subseriesCodes = @json($subseriesCodes);

    // Lee el código de la dependencia seleccionada
    function getDepCode() {
        const sel = document.getElementById('dependencia_id');
        return sel?.selectedOptions[0]?.dataset.depCodigo || '';
    }

    document.getElementById('rows-container').addEventListener('change', function(e) {
        const row = e.target.closest('.inventario-row');
        if (!row) return;

        const depCode = getDepCode();
        const codigoInput = row.querySelector('input[name="codigo[]"]');

        // 1) cambio de serie: recalcula código y limpia subserie
        if (e.target.classList.contains('serie-select')) {
            const opt = e.target.selectedOptions[0];
            const serieC = opt?.dataset.serieCodigo;
            // si no hay serie, despeja todo
            if (!serieC) {
                codigoInput.value = '';
                row.querySelector('.usa-subserie-checkbox').checked = false;
                const subSel = row.querySelector('.subserie-select');
                subSel.disabled = true;
                subSel.innerHTML = `<option>– Primero activa checkbox –</option>`;
                return;
            }
            // serie sola: DEP.SERIE.00
            codigoInput.value = `${depCode}.${serieC}.00`;
            // resetea subserie
            const subSel = row.querySelector('.subserie-select');
            subSel.disabled = true;
            subSel.innerHTML = `<option>– Primero activa checkbox –</option>`;
            row.querySelector('.usa-subserie-checkbox').checked = false;
        }

        // 2) si marcó usa-subserie-checkbox: habilita select y carga opciones
        if (e.target.classList.contains('usa-subserie-checkbox')) {
            const usa = e.target.checked;
            const subSel = row.querySelector('.subserie-select');
            subSel.disabled = !usa;

            // Si activó y ya hay una serie seleccionada
            const serieId = row.querySelector('.serie-select').value;
            if (usa && serieId && subseriesData[serieId]) {
                // arma opciones
                let opts = `<option value="">– Seleccione subserie –</option>`;
                for (let [subId, subName] of Object.entries(subseriesData[serieId])) {
                    opts += `<option value="${subId}"
                       data-subserie-codigo="${subseriesCodes[subId]}">
                   ${subName}
                 </option>`;
                }
                subSel.innerHTML = opts;
            }
            // si desactiva, regresa al código DEP.SERIE.00
            if (!usa) {
                const serieOpt = row.querySelector('.serie-select').selectedOptions[0];
                const serieC = serieOpt?.dataset.serieCodigo;
                codigoInput.value = `${depCode}.${serieC}.00`;
            }
        }

        // 3) al elegir subserie: recalcula a DEP.SERIE.SUB
        if (e.target.classList.contains('subserie-select')) {
            const subOpt = e.target.selectedOptions[0];
            const serieOpt = row.querySelector('.serie-select').selectedOptions[0];
            const serieC = serieOpt?.dataset.serieCodigo;
            const subC = subOpt?.dataset.subserieCodigo;
            if (serieC && subC) {
                codigoInput.value = `${depCode}.${serieC}.${subC}`;
            }
        }
    });

    function getDepCode() {
        const sel = document.getElementById('dependencia_id');
        return sel.selectedOptions[0]?.dataset.depCodigo || '';
    }

    document.getElementById('rows-container')
        .addEventListener('change', function(e) {
            const row = e.target.closest('.inventario-row');
            if (!row) return;
            const depCode = getDepCode();
            const codeInput = row.querySelector('.codigo-field');

            // Cuando elige serie:
            if (e.target.classList.contains('serie-select')) {
                const serieC = e.target.selectedOptions[0]?.dataset.serieCodigo;
                codeInput.value = serieC ?
                    `${depCode}.${serieC}.00` :
                    '';
                // reset subserie...
            }

            // Cuando activa subserie-checkbox:
            if (e.target.classList.contains('usa-subserie-checkbox')) {
                // carga opciones de subserie...
                // si desactiva:
                if (!e.target.checked) {
                    const serieC = row.querySelector('.serie-select')
                        .selectedOptions[0]?.dataset.serieCodigo;
                    codeInput.value = `${depCode}.${serieC}.00`;
                }
            }

            // Cuando elige subserie:
            if (e.target.classList.contains('subserie-select')) {
                const serieC = row.querySelector('.serie-select')
                    .selectedOptions[0]?.dataset.serieCodigo;
                const subC = e.target.selectedOptions[0]
                    ?.dataset.subserieCodigo;
                codeInput.value = `${depCode}.${serieC}.${subC}`;
            }
        });
</script>
