<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Panel de Administración' }}</title>

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- css para el sidebar -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

</head>

<body>
    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/home') }}">ARCHIVA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/perfil') }}">
                            <i class="fa fa-user-circle me-1"></i> Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm ms-2">
                                <i class="fa fa-sign-out-alt"></i> Salir
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

   <div class="d-flex">
        <!-- Botón para colapsar/expandir sidebar -->
        <div class="position-fixed" style="z-index: 1040; left: 0.5rem; top: 4rem;">
            <button id="sidebarToggle" class="btn btn-outline-secondary">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Sidebar modificado -->
        <nav id="sidebarMenu" class="sidebar bg-light border-end">
            
            <div class="nav flex-column mt-5">
                <a href="{{ url('/home') }}"
                    class="nav-link d-flex align-items-center p-3 {{ request()->is('home') ? 'active' : '' }}">
                    <i class="fas fa-home me-3"></i>
                    <span class="hide-on-collapse">Dashboard</span>
                </a>

                @if (auth()->user()->role && in_array(auth()->user()->role->nombre_rol, ['admin', 'archivista']))
                    <a href="{{ route('inventarios.transferencias.index') }}"
                        class="nav-link d-flex align-items-center p-3 {{ request()->is('inventarios/transferencias*') ? 'active' : '' }}">
                        <i class="fas fa-archive me-3"></i>
                        <span class="hide-on-collapse">Transferencias</span>
                    </a>
                @endif

                <a href="{{ route('prestamos.index') }}"
                    class="nav-link d-flex align-items-center p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
                    <i class="fas fa-book me-3"></i>
                    <span class="hide-on-collapse">Préstamos</span>
                </a>

                @if (auth()->user()->role && auth()->user()->role->nombre_rol == 'admin')
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link d-flex align-items-center p-3 {{ request()->is('admin/users*') ? 'active' : '' }}">
                        <i class="fas fa-users me-3"></i>
                        <span class="hide-on-collapse">Usuarios</span>
                    </a>
                @endif

        @if(auth()->user()->role && auth()->user()->role->nombre_rol == 'admin')
          <a
            href="{{ route('admin.roles.index') }}"
            class="nav-link d-flex align-items-center p-3 {{ request()->is('admin/roles*') ? 'active' : '' }}"
          >
            <i class="fa-solid fa-users-gear me-3"></i>
            <span class="hide-on-collapse">Roles</span>
          </a>
        @endif

                @if (auth()->user()->role && in_array(auth()->user()->role->nombre_rol, ['admin', 'archivista']))
                    <a href="{{ route('inventarios.dependencias.index') }}"
                        class="nav-link d-flex align-items-center p-3 {{ request()->is('inventarios/dependencias*') ? 'active' : '' }}">
                        <i class="fas fa-building me-3"></i>
                        <span class="hide-on-collapse">Dependencias</span>
                    </a>
                @endif

                @if (auth()->user()->role && in_array(auth()->user()->role->nombre_rol, ['admin', 'archivista']))
                    <a href="{{ route('inventarios.ubicaciones.index') }}"
                        class="nav-link d-flex align-items-center p-3 {{ request()->is('inventarios/ubicaciones*') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt me-3"></i>
                        <span class="hide-on-collapse">Ubicaciones</span>
                    </a>
                @endif

                @if (auth()->user()->role && in_array(auth()->user()->role->nombre_rol, ['admin', 'archivista']))
                    <a href="{{ route('inventarios.soportes.index') }}"
                        class="nav-link d-flex align-items-center p-3 {{ request()->is('inventarios/soportes*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-3"></i>
                        <span class="hide-on-collapse">Soportes</span>
                    </a>
                @endif


                @if (auth()->user()->role && in_array(auth()->user()->role->nombre_rol, ['admin', 'archivista']))
                    {{-- Link a Series Documentales --}}
                    <a href="{{ route('inventarios.series.index') }}"
                        class="nav-link d-flex align-items-center p-3 {{ request()->routeIs('inventarios.series.*') ? 'active' : '' }}">
                        <i class="fas fa-layer-group me-3"></i>
                        <span class="hide-on-collapse">Series Doc.</span>
                    </a>

                    <a href="{{ route('inventarios.tipos-documentales.index') }}"
                        class="nav-link d-flex align-items-center p-3 {{ request()->routeIs('inventarios.tipos-documentales.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt me-3"></i>
                        <span class="hide-on-collapse">Tipos Documentales</span>
                    </a>
                @endif
            </div>
        </nav>

           <!-- Contenido Principal -->
        <main class="main-content">
            <div class="container-fluid mt-4">
                {{ $slot }}
            </div>
        </main>
    </div>

    <x-alert-modal />

    <!-- Bootstrap 5.3 Bundle JS (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>

    <!-- Feather Icons (opcional) -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <!-- js para el sidebar -->
    <script src="{{ asset('js/admin.js') }}"></script>
    


    @stack('scripts')
</body>

</html>
