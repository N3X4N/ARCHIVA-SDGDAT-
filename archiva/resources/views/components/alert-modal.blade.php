{{-- resources/views/components/alert-modal.blade.php --}}
<div class="modal fade" id="alertModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body text-center p-4">
                <i id="alert-icon" class="fa-4x mb-3"></i>
                <div id="alert-message" class="h5 mb-4"></div>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            function showAlert(type, message) {
                const icon = document.getElementById('alert-icon');
                const msg = document.getElementById('alert-message');
                // resetea
                icon.className = 'fa-4x mb-3';
                msg.textContent = message;
                // asigna icono y color según tipo
                switch (type) {
                    case 'success':
                        icon.classList.add('fas', 'fa-check-circle', 'text-success');
                        break;
                    case 'error':
                        icon.classList.add('fas', 'fa-times-circle', 'text-danger');
                        break;
                    case 'warning':
                        icon.classList.add('fas', 'fa-exclamation-triangle', 'text-warning');
                        break;
                    default:
                        icon.classList.add('fas', 'fa-info-circle', 'text-info');
                }
                // dispara modal (Bootstrap 5)
                const bsModal = new bootstrap.Modal(document.getElementById('alertModal'));
                bsModal.show();
            }

            document.addEventListener('DOMContentLoaded', () => {
                // 1) si viene en session
                @if (session('alertType') && session('alertMessage'))
                    showAlert("{{ session('alertType') }}", "{{ session('alertMessage') }}");
                @endif

                // 2) escucha eventos personalizados
                window.addEventListener('show-alert', e => {
                    showAlert(e.detail.type, e.detail.message);
                });
            });
        </script>
    @endpush
@endonce
