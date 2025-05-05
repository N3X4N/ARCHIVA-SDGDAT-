<!-- resources/views/inventarios/transferencias/create.blade.php -->
<x-admin-layout>
    <x-slot name="title">Crear Transferencia Documental</x-slot>

    <div class="container">
        <h1 class="mb-4">Crear Nueva Transferencia Documental</h1>

        <form action="{{ route('inventarios.transferencias.store') }}" method="POST">
            @csrf
            @include('inventarios.transferencias._form', [
                'transferencia' => new \App\Models\TransferenciaDocumental(),
            ])

            <button type="submit" class="btn btn-success">Guardar Transferencia</button>
            <a href="{{ route('inventarios.transferencias.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>



        {{-- <!-- Formato de Inventario Documental -->
        <div class="mt-5">
            <h2>Formato de Inventario Documental</h2>

            <!-- Contenedor principal para el formato -->
            <div class="excel-format">
                <div class="container">
                    <div class="row">
                        <!-- Columna lateral izquierda -->
                        <div class="col-sm-3">
                            <div class="text-center">
                                Nivel 1: .col-sm-3 (Izquierda)
                            </div>
                        </div>

                        <!-- Columna central (contenido) -->
                        <div class="col-sm-6">
                            <!-- Imagen -->
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>Proceso Gestión Documental y Archivo</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>Formato único de inventario documental</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Columna lateral derecha -->
                        <div class="col-sm-3">
                            <div class="text-center">
                                Nivel 1: .col-sm-3 (Derecha)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <!-- Contenedor principal para el formato -->
        <div class="excel-format">
            <div class="container">
                <!-- Fila con los primeros 4 campos -->
                <div class="row mb-4">
                    <div class="col-sm-3">
                        <label for="dependencia_id"><strong>Entidad Remitente</strong></label>
                        <input type="text" name="dependencia_id" class="form-control"
                            value="{{ old('dependencia_id') }}" required />
                    </div>
                    <div class="col-sm-3">
                        <label for="serie_documental_id"><strong>Entidad Productora</strong></label>
                        <input type="text" name="serie_documental_id" class="form-control"
                            value="{{ old('serie_documental_id') }}" required />
                    </div>

                    <!-- Espacio en el medio -->
                    <div class="col-sm-4">
                        <div></div>
                        <div class="col-sm-8 center">
                            <strong>REGISTRO DE ENTRADA</strong>
                        </div>

                    </div>
                </div>

                <!-- Fila de los siguientes 4 campos (Unidad Administrativa, Oficina Productora, Año, Mes, Día) -->
                <div class="row mb-4">
                    <div class="col-sm-3">
                        <label for="subserie_documental_id"><strong>Unidad Administrativa</strong></label>
                        <input type="text" name="subserie_documental_id" class="form-control"
                            value="{{ old('subserie_documental_id') }}" required />
                    </div>

                    <div class="col-sm-3">
                        <label for="entregado_por"><strong>Oficina Productora</strong></label>
                        <input type="text" name="entregado_por" class="form-control"
                            value="{{ old('entregado_por') }}" required />
                    </div>

                    <!-- Año, Mes, Día -->
                    <div class="col-sm-2">
                        <label for="fecha_extrema_inicial"><strong>AÑO</strong></label>
                        <input type="text" name="fecha_extrema_inicial" class="form-control"
                            value="{{ old('fecha_extrema_inicial', \Carbon\Carbon::parse(old('fecha_extrema_inicial'))->format('Y')) }}"
                            required />
                    </div>
                    <div class="col-sm-2">
                        <label for="fecha_extrema_final"><strong>MES</strong></label>
                        <input type="text" name="fecha_extrema_final" class="form-control"
                            value="{{ old('fecha_extrema_final', \Carbon\Carbon::parse(old('fecha_extrema_final'))->format('m')) }}"
                            required />
                    </div>

                    <div class="col-sm-2">
                        <label for="numero_transferencia"><strong>DÍA</strong></label>
                        <input type="text" name="numero_transferencia" class="form-control"
                            value="{{ old('numero_transferencia') }}" required />
                    </div>

                </div>

                <!-- Fila con el Dobjeto  y el N° T -->
                <div class="row mb-4">

                    <div class="col-sm-8">
                        <label for="observaciones"><strong>Objeto</strong></label>
                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
                    </div>

                    <!-- Año, Mes, Día -->
                    <div class="col-sm-4">
                        <label for="numero_transferencia"><strong>N° T</strong></label>
                        <input type="text" name="numero_transferencia" class="form-control"
                            value="{{ old('numero_transferencia') }}" required />
                    </div>
                </div>

                <br>

                <!-- Fila con los campos adicionales -->
                <div class="row mb-4">
                    <!-- NOMBRE DE LAS SERIES, SUBSERIE O ASUNTOS -->
                    <div class="col-sm-6">
                        <label for="nombre_series_subserie"><strong>NOMBRE DE LAS SERIES, SUBSERIE O
                                ASUNTOS</strong></label>
                        <input type="text" name="nombre_series_subserie" class="form-control"
                            value="{{ old('nombre_series_subserie') }}" required />
                    </div>

                    <!-- Fechas Extremas (INICIAL y FINAL) -->
                    <div class="col-sm-3">
                        <label for="fecha_extrema_inicial"><strong>FECHA INICIAL</strong></label>
                        <input type="date" name="fecha_extrema_inicial" class="form-control"
                            value="{{ old('fecha_extrema_inicial') }}" required />
                    </div>
                    <div class="col-sm-3">
                        <label for="fecha_extrema_final"><strong>FECHA FINAL</strong></label>
                        <input type="date" name="fecha_extrema_final" class="form-control"
                            value="{{ old('fecha_extrema_final') }}" required />
                    </div>
                </div>

                <!-- Unidad de Conservación (Caja, Carpeta, Resolución, Otro) -->
                <div class="row mb-4">
                    <div class="col-sm-3">
                        <label for="caja"><strong>Caja</strong></label>
                        <input type="number" name="caja" class="form-control" value="{{ old('caja') }}"
                            required />
                    </div>
                    <div class="col-sm-3">
                        <label for="carpeta"><strong>Carpeta</strong></label>
                        <input type="number" name="carpeta" class="form-control" value="{{ old('carpeta') }}"
                            required />
                    </div>
                    <div class="col-sm-3">
                        <label for="resolucion"><strong>Resolución</strong></label>
                        <input type="number" name="resolucion" class="form-control"
                            value="{{ old('resolucion') }}" required />
                    </div>
                    <div class="col-sm-3">
                        <label for="otro"><strong>Otro</strong></label>
                        <input type="number" name="otro" class="form-control" value="{{ old('otro') }}"
                            required />
                    </div>
                </div>

                <!-- Número de Folios -->
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <label for="numero_folios"><strong>Número de Folios</strong></label>
                        <input type="number" name="numero_folios" class="form-control"
                            value="{{ old('numero_folios') }}" required />
                    </div>

                    <!-- Soporte -->
                    <div class="col-sm-4">
                        <label for="soporte"><strong>Soporte</strong></label>
                        <input type="text" name="soporte" class="form-control" value="{{ old('soporte') }}"
                            required />
                    </div>

                    <!-- Frecuencia de Consulta -->
                    <div class="col-sm-4">
                        <label for="frecuencia_consulta"><strong>Frecuencia de Consulta</strong></label>
                        <input type="text" name="frecuencia_consulta" class="form-control"
                            value="{{ old('frecuencia_consulta') }}" required />
                    </div>
                </div>

                <!-- Ubicación -->
                <div class="row mb-4">
                    <div class="col-sm-4">
                        <label for="ubicacion_caja"><strong>Ubicación Caja</strong></label>
                        <input type="text" name="ubicacion_caja" class="form-control"
                            value="{{ old('ubicacion_caja') }}" required />
                    </div>
                    <div class="col-sm-4">
                        <label for="ubicacion_bandeja"><strong>Ubicación Bandeja</strong></label>
                        <input type="text" name="ubicacion_bandeja" class="form-control"
                            value="{{ old('ubicacion_bandeja') }}" required />
                    </div>
                    <div class="col-sm-4">
                        <label for="ubicacion_estante"><strong>Ubicación Estante</strong></label>
                        <input type="text" name="ubicacion_estante" class="form-control"
                            value="{{ old('ubicacion_estante') }}" required />
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="row mb-4">
                    <div class="col-sm-12">
                        <label for="observaciones"><strong>Observaciones</strong></label>
                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
                    </div>
                </div>

                <!-- Campo de "Objeto" con más espacio -->

            </div>
        </div> --}}
    </div>

</x-admin-layout>
