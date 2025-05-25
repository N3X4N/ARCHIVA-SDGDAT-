@php
    $currentPrestamo = $prestamo ?? null;
    $now = \Carbon\Carbon::now();
@endphp

<!-- Estructura similar al _form de inventario -->
<div class="mt-2"> {{-- Reducido el mt-5 para que no quede tan separado del título de la página create/edit --}}
    {{-- El título "Formulario de Préstamo" o similar lo maneja la vista create/edit.blade.php --}}

    <div class="excel-format"> {{-- Manteniendo esta clase por consistencia con tu ejemplo --}}
        <div class="container"> {{-- Manteniendo este contenedor por consistencia --}}

            {{-- ----- Fila 1: Solicitante, Receptor ----- --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6">
                    <label for="user_id_solicitante" class="form-label"><strong>Usuario Solicitante <span class="text-danger">*</span></strong></label>
                    <select name="user_id_solicitante" id="user_id_solicitante" class="form-select @error('user_id_solicitante') is-invalid @enderror" required>
                        <option value="">Seleccione...</option>
                        @foreach ($users as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ old('user_id_solicitante', $currentPrestamo->user_id_solicitante ?? '') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id_solicitante')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-6">
                    <label for="user_id_receptor" class="form-label"><strong>Usuario Receptor</strong> (Quien entrega)</label>
                    <select name="user_id_receptor" id="user_id_receptor" class="form-select @error('user_id_receptor') is-invalid @enderror">
                        <option value="">Seleccione si aplica...</option>
                        @foreach ($users as $id => $nombre)
                            <option value="{{ $id }}"
                                {{ old('user_id_receptor', $currentPrestamo->user_id_receptor ?? '') == $id ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id_receptor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ----- Fila 2: Fechas ----- --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <label for="fecha_prestamo" class="form-label"><strong>Fecha Préstamo <span class="text-danger">*</span></strong></label>
                    <input type="datetime-local" name="fecha_prestamo" id="fecha_prestamo" class="form-control @error('fecha_prestamo') is-invalid @enderror"
                           value="{{ old('fecha_prestamo', $currentPrestamo && $currentPrestamo->fecha_prestamo ? $currentPrestamo->fecha_prestamo->format('Y-m-d\TH:i') : $now->format('Y-m-d\TH:i')) }}" required>
                    @error('fecha_prestamo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label for="fecha_vencimiento" class="form-label"><strong>Fecha Vencimiento</strong></label>
                    <input type="datetime-local" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                           value="{{ old('fecha_vencimiento', $currentPrestamo && $currentPrestamo->fecha_vencimiento ? $currentPrestamo->fecha_vencimiento->format('Y-m-d\TH:i') : '') }}">
                    @error('fecha_vencimiento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label for="fecha_devolucion" class="form-label"><strong>Fecha Devolución</strong></label>
                    <input type="datetime-local" name="fecha_devolucion" id="fecha_devolucion" class="form-control @error('fecha_devolucion') is-invalid @enderror"
                           value="{{ old('fecha_devolucion', $currentPrestamo && $currentPrestamo->fecha_devolucion ? $currentPrestamo->fecha_devolucion->format('Y-m-d\TH:i') : '') }}"
                           {{ (old('estado', $currentPrestamo->estado ?? '') === 'devuelto') ? '' : 'disabled' }}
                    >
                    @error('fecha_devolucion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Se habilita al marcar estado como "Devuelto".</small>
                </div>
            </div>

            {{-- ----- Fila 3: Estado, Firmas (si se mantienen como textarea) ----- --}}
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <label for="estado" class="form-label"><strong>Estado <span class="text-danger">*</span></strong></label>
                    <select name="estado" id="estado" class="form-select @error('estado') is-invalid @enderror" required>
                        <option value="prestado" {{ old('estado', $currentPrestamo->estado ?? 'prestado') == 'prestado' ? 'selected' : '' }}>Prestado</option>
                        <option value="devuelto" {{ old('estado', $currentPrestamo->estado ?? '') == 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                        <option value="vencido" {{ old('estado', $currentPrestamo->estado ?? '') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label for="firma_solicitante" class="form-label"><strong>Firma Solicitante</strong></label>
                    <textarea name="firma_solicitante" id="firma_solicitante" class="form-control @error('firma_solicitante') is-invalid @enderror" rows="2">{{ old('firma_solicitante', $currentPrestamo->firma_solicitante ?? '') }}</textarea>
                    @error('firma_solicitante')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label for="firma_receptor" class="form-label"><strong>Firma Receptor</strong></label>
                    <textarea name="firma_receptor" id="firma_receptor" class="form-control @error('firma_receptor') is-invalid @enderror" rows="2">{{ old('firma_receptor', $currentPrestamo->firma_receptor ?? '') }}</textarea>
                    @error('firma_receptor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ----- Fila 4: Observaciones, Activo ----- --}}
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label for="observaciones" class="form-label"><strong>Observaciones</strong></label>
                    <textarea name="observaciones" id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="3">{{ old('observaciones', $currentPrestamo->observaciones ?? '') }}</textarea>
                    @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $currentPrestamo->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Activo
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const estadoSelect = document.getElementById('estado');
    const fechaDevolucionInput = document.getElementById('fecha_devolucion');

    function toggleFechaDevolucion() {
        if (estadoSelect && fechaDevolucionInput) {
            if (estadoSelect.value === 'devuelto') {
                fechaDevolucionInput.disabled = false;
            } else {
                fechaDevolucionInput.disabled = true;
                // Si no es 'devuelto', podrías querer limpiar el campo:
                // fechaDevolucionInput.value = '';
            }
        }
    }

    if (estadoSelect) {
        estadoSelect.addEventListener('change', toggleFechaDevolucion);
        // Ejecutar al cargar para establecer el estado inicial del input de fecha_devolucion
        toggleFechaDevolucion();
    }
});
</script>
@endpush