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

     //  función para cerrar al hacer clic fuera
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebarMenu');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const isExpanded = !sidebar.classList.contains('collapsed');
        
        // Elementos que no deben cerrar el sidebar
        const isClickInside = sidebar.contains(event.target) || 
                            sidebarToggle.contains(event.target);
        
        if (!isClickInside && isExpanded && window.innerWidth > 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('collapsed');
            localStorage.setItem('sidebarCollapsed', true);
        }
    });

    // maneja el responsive
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('collapsed');
            localStorage.setItem('sidebarCollapsed', true);
        }
    });
});