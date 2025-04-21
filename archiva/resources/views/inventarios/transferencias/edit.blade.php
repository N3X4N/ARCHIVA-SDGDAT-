@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serieSelect = document.querySelector('select[name="serie_documental_id"]');
            const subserieSelect = document.querySelector('select[name="subserie_documental_id"]');
            const subserieActual = "{{ old('subserie_documental_id', $transferencia->subserie_documental_id) }}";

            function cargarSubseries(serieId, selected = null) {
                subserieSelect.innerHTML = '<option value="">Cargando...</option>';

                fetch(`/subseries-por-serie/${serieId}`)
                    .then(res => res.json())
                    .then(data => {
                        let options = '<option value="">Seleccione...</option>';
                        data.forEach(subserie => {
                            const selectedAttr = (selected && selected == subserie.id) ? 'selected' :
                            '';
                            options +=
                                `<option value="${subserie.id}" ${selectedAttr}>${subserie.nombre}</option>`;
                        });
                        subserieSelect.innerHTML = options;
                    });
            }

            // Evento cuando cambia la serie
            serieSelect.addEventListener('change', function() {
                cargarSubseries(this.value);
            });

            // Al cargar por primera vez (modo edición)
            if (serieSelect.value) {
                cargarSubseries(serieSelect.value, subserieActual);
            }
        });
    </script>
@endpush
