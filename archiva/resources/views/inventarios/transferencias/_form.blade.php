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
                    <input type="text" name="serie_documental_id" class="form-control"
                        value="{{ old('serie_documental_id', 'SECRETARIA DE PLANEACION') }}" required />
                </div>

                <div class="col-12 col-md-4">
                    <label for="serie_documental_id"><strong>Unidad Administrativa</strong></label>
                    <input type="text" name="serie_documental_id" class="form-control"
                        value="{{ old('serie_documental_id', 'ALCALDIA MUNICIPAL DE TABIO ') }}" required />
                </div>

                <div class="col-12 col-md-4">
                    <label for="entregado_por"><strong>Oficina Productora</strong></label>
                    <input type="text" name="entregado_por" class="form-control"
                        value="{{ old('entregado_por', 'SECRETARIA DE PLANEACION') }}" required />
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
                    <label for="fecha_extrema_inicial"><strong>AÑO</strong></label>
                    <input type="text" name="fecha_extrema_inicial" class="form-control"
                        value="{{ old('fecha_extrema_inicial', now()->format('Y')) }}" required />
                </div>
                <div class="col-12 col-md-4">
                    <label for="fecha_extrema_final"><strong>MES</strong></label>
                    <input type="text" name="fecha_extrema_final" class="form-control"
                        value="{{ old('fecha_extrema_final', now()->format('m')) }}" required />
                </div>
                <div class="col-12 col-md-4">
                    <label for="numero_transferencia"><strong>DÍA</strong></label>
                    <input type="text" name="numero_transferencia" class="form-control"
                        value="{{ old('numero_transferencia', now()->format('d')) }}" required />
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
    // Función para agregar una nueva fila al formulario
    function addRow() {
        const container = document.getElementById('rows-container');
        const rowHTML = `
            <div class="row mb-4">
                <!-- Número de Orden -->
                <div class="col-12 col-md-2">
                    <label>Número de Orden</label>
                    <input type="text" name="numero_orden[]" class="form-control">
                </div>
                <!-- Código -->
                <div class="col-12 col-md-2">
                    <label>Código</label>
                    <input type="text" name="codigo[]" class="form-control">
                </div>
                <!-- Nombre de las Series/Subserie -->
                <div class="col-12 col-md-4">
                    <label>Nombre de las Series/Subserie o asuntos</label>
                    <input type="text" name="nombre_series_subserie[]" class="form-control">
                </div>
                <!-- Fecha Inicial -->
                <div class="col-12 col-md-2">
                    <label>Fecha Inicial</label>
                    <input type="date" name="fecha_inicial[]" class="form-control">
                </div>
                <!-- Fecha Final -->
                <div class="col-12 col-md-2">
                    <label>Fecha Final</label>
                    <input type="date" name="fecha_final[]" class="form-control">
                </div>
                <!-- Caja -->
                <div class="col-12 col-md-2">
                    <label>Caja</label>
                    <input type="number" name="caja[]" class="form-control">
                </div>
                <!-- Carpeta -->
                <div class="col-12 col-md-2">
                    <label>Carpeta</label>
                    <input type="number" name="carpeta[]" class="form-control">
                </div>
                <!-- Resolución -->
                <div class="col-12 col-md-2">
                    <label>Resolución</label>
                    <input type="number" name="resolucion[]" class="form-control">
                </div>
                <!-- Otro -->
                <div class="col-12 col-md-2">
                    <label>Otro</label>
                    <input type="number" name="otro[]" class="form-control">
                </div>
                <!-- Número de Folios -->
                <div class="col-12 col-md-2">
                    <label>Número de Folios</label>
                    <input type="number" name="numero_folios[]" class="form-control">
                </div>
                <!-- Soporte -->
                <div class="col-12 col-md-2">
                    <label>Soporte</label>
                    <input type="text" name="soporte[]" class="form-control">
                </div>
                <!-- Frecuencia de Consulta -->
                <div class="col-12 col-md-2">
                    <label>Frecuencia de Consulta</label>
                    <input type="text" name="frecuencia_consulta[]" class="form-control">
                </div>
                <!-- Ubicación Caja -->
                <div class="col-12 col-md-2">
                    <label>Ubicación Caja</label>
                    <input type="text" name="ubicacion_caja[]" class="form-control">
                </div>
                <!-- Ubicación Bandeja -->
                <div class="col-12 col-md-2">
                    <label>Ubicación Bandeja</label>
                    <input type="text" name="ubicacion_bandeja[]" class="form-control">
                </div>
                <!-- Ubicación Estante -->
                <div class="col-12 col-md-2">
                    <label>Ubicación Estante</label>
                    <input type="text" name="ubicacion_estante[]" class="form-control">
                </div>
                <!-- Observaciones -->
                <div class="col-12 col-md-2">
                    <label>Observaciones</label>
                    <input type="text" name="observaciones[]" class="form-control">
                </div>
                <!-- Botón Eliminar -->
                <div class="col-12 col-md-1">
                    <button type="button" class="btn btn-danger" onclick="removeRow(this)">Eliminar</button>
                </div>
            </div>
            <hr>
        `;
        container.insertAdjacentHTML('beforeend', rowHTML);
    }

    // Función para eliminar una fila
    function removeRow(button) {
        button.parentElement.parentElement.remove();
    }
</script>
