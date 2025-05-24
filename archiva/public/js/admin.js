document.addEventListener('DOMContentLoaded', function() {
    // Toggle del Sidebar
    const sidebar = document.getElementById('sidebarMenu');
    const mainContent = document.querySelector('.main-content');
    const sidebarToggle = document.getElementById('sidebarToggle');

    // Cargar estado del sidebar
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if(isCollapsed) {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('collapsed');
    }

    // Evento click del botón
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('collapsed');
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
    });

    // Eventos adicionales para la tabla (si los necesitas)
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', () => {
            // Lógica de edición aquí
        });
    });
});