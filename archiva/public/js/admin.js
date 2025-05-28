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

    // Función para cerrar al hacer clic fuera del sidebar
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebarMenu');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const isExpanded = !sidebar.classList.contains('collapsed');
        
        // Verificar si el clic fue dentro del sidebar o en el toggle
        const isClickInside = sidebar.contains(event.target) || 
                            sidebarToggle.contains(event.target);
        
        // Verificar si el clic fue en un enlace del sidebar
        const isNavLink = event.target.closest('.nav-link');
        
        // Solo cerrar si:
        // 1. El clic NO fue dentro del sidebar
        // 2. El clic NO fue en el toggle
        // 3. El sidebar está expandido
        // 4. La pantalla es mayor a 768px
        // 5. NO es un enlace de navegación
        if (!isClickInside && isExpanded && window.innerWidth > 768 && !isNavLink) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('collapsed');
            localStorage.setItem('sidebarCollapsed', true);
        }
    });

    // Maneja el responsive
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('collapsed');
            localStorage.setItem('sidebarCollapsed', true);
        }
    });

    // SOLUCIÓN ALTERNATIVA: Prevenir el cierre cuando se hace clic en enlaces del sidebar
    sidebar.addEventListener('click', function(event) {
        // Si el clic es en un enlace, prevenir que se propague al document
        if (event.target.closest('.nav-link')) {
            event.stopPropagation();
        }
    });
});