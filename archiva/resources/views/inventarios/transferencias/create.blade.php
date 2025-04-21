@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const serieSelect = document.querySelector('select[name="serie_documental_id"]');
    const subserieSelect = document.querySelector('select[name="subserie_documental_id"]');
    const subserieAnterior = "{{ old('subserie_documental_id') }}";

    function cargarSubseries(serieId, selected = null) {
      // Limpia las opciones previas
      subserieSelect.innerHTML = '<option value="">Cargando...</option>';

      fetch(`/subseries-por-serie/${serieId}`)
        .then(res => res.json())
        .then(data => {
          let options = '<option value="">Seleccione...</option>';

          // Si no hay subseries, no agrega opciones adicionales
          if (data.length === 0) {
            subserieSelect.innerHTML = '<option value="">No hay subseries disponibles</option>';
            return;
          }

          data.forEach(subserie => {
            // Compara la subserie seleccionada con la que está en `old()`
            const selectedAttr = (selected && selected == subserie.id) ? 'selected' : '';
            options += `<option value="${subserie.id}" ${selectedAttr}>${subserie.nombre}</option>`;
          });

          // Asigna las opciones al select
          subserieSelect.innerHTML = options;
        })
        .catch(error => {
          console.error('Error al cargar las subseries:', error);
          subserieSelect.innerHTML = '<option value="">Error al cargar las subseries</option>';
        });
    }

    // Evento cuando se cambia la serie
    serieSelect.addEventListener('change', function () {
      cargarSubseries(this.value);
    });

    // Cargar subseries si ya hay una serie seleccionada al volver por errores
    if (serieSelect.value) {
      cargarSubseries(serieSelect.value, subserieAnterior);
    }
  });
</script>
@endpush
