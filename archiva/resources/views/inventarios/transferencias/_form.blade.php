<!-- Formato de Inventario Documental -->
<div class="mt-5">
    <h2>Formato de Inventario Documental</h2>

    <!-- Contenedor principal para el formato -->
    <div class="excel-format">
        <div class="container">
            <!-- Fila con los primeros 3 campos (Entidad Remitente, Entidad Productora, Oficina Productora) -->
            <div class="row mb-4">
                <div class="col-12 col-md-4">
                    <label for="dependencia_id"><strong>Entidad Remitente</strong></label>
                    <select name="dependencia_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        @foreach ($dependencias as $id => $nombre)
                            <option value="{{ $id }}" {{ old('dependencia_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label for="serie_documental_id"><strong>Entidad Productora</strong></label>
                    <select name="dependencia_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        @foreach ($dependencias as $id => $nombre)
                            <option value="{{ $id }}" {{ old('dependencia_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-4">
                    <label for="serie_documental_id"><strong>Unidad Administrativa</strong></label>
                    <input type="text" name="serie_documental_id" class="form-control"
                        value="{{ old('serie_documental_id', 'ALCALDIA MUNICIPAL DE TABIO ') }}" required />
                </div>

                <div class="col-12 col-md-4">
                    <label for="entregado_por"><strong>Oficina Productora</strong></label>
                    <select name="dependencia_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        @foreach ($dependencias as $id => $nombre)
                            <option value="{{ $id }}" {{ old('dependencia_id') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-4">
                <div></div>
                <div class="col-sm-8 center">
                    <strong>REGISTRO DE ENTRADA</strong>
                </div>
            </div>

            <!-- Fila con los campos de fecha (Año, Mes, Día) con fecha del día de creación -->
            <div class="row mb-4">
                <div class="col-12 col-md-4">
                    <label><strong>AÑO</strong></label>
                    <input type="text" name="fecha_extrema_inicial" class="form-control"
                        value="{{ old('fecha_extrema_inicial', now()->format('Y')) }}" readonly>
                </div>
                <div class="col-12 col-md-4">
                    <label><strong>MES</strong></label>
                    <input type="text" name="fecha_extrema_final" class="form-control"
                        value="{{ old('fecha_extrema_final', now()->format('m')) }}" readonly>
                </div>
                <div class="col-12 col-md-4">
                    <label><strong>DÍA</strong></label>
                    <input type="text" name="dia_creacion" class="form-control"
                        value="{{ old('dia_creacion', now()->format('d')) }}" readonly>
                </div>
            </div>

            <!-- Número de Transferencia (generado como un consecutivo) -->
            <div class="row mb-4">
                <div class="col-12 col-md-4">
                    <label for="numero_transferencia"><strong>N° T</strong></label>
                    <input type="text" name="numero_transferencia" class="form-control"
                        value="{{ old('numero_transferencia', $nextTransferNumber) }}" readonly required />
                </div>
            </div>

            <!-- Fila con los campos dinámicos (Número de Orden, Código, Nombre de las Series, Fechas, etc.) -->
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
    function addRow () {
        const container = document.getElementById('rows-container');

        container.insertAdjacentHTML('beforeend', `
            <div class="row g-3 align-items-end mb-4 inventario-row">
                <div class="col-6 col-md-2">
                    <label class="form-label">N° Orden</label>
                    <input type="text" name="numero_orden[]" class="form-control numero-orden" readonly>
                </div>

                <div class="col-6 col-md-2">
                    <label class="form-label">Código</label>
                    <input type="text" name="codigo[]" class="form-control">
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">Serie / Subserie</label>
                    <input type="text" name="nombre_series_subserie[]" class="form-control">
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

        actualizarOrdenes();         // numera después de añadir
    }

    /* ========== Quitar fila ========== */
    function removeRow (btn) {
        const fila = btn.closest('.inventario-row');  // fila a eliminar
        const hr   = fila.nextElementSibling;         // línea divisora

        fila.remove();
        if (hr && hr.tagName === 'HR') hr.remove();

        actualizarOrdenes();         // re‑numera después de borrar
    }

    /* ========== Recalcular N° Orden ========== */
    function actualizarOrdenes () {
        document
            .querySelectorAll('#rows-container .inventario-row')
            .forEach((row, idx) => {
                row.querySelector('.numero-orden').value = idx + 1;
            });
    }
    </script>
