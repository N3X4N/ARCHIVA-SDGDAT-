<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Panel de Administración' }}</title>

  <!-- Bootstrap 5.3 CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
    crossorigin="anonymous"
  >

  <!-- Font Awesome -->
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    rel="stylesheet"
  >

  <style>
    /* Sidebar styles */
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 56px; /* Altura navbar */
      left: 0;
      width: 220px;
      background-color: #2E5077;
      color: #fff;
      transition: width 0.3s;
      overflow: hidden;
    }
    .sidebar.collapsed { width: 60px; }
    .sidebar .nav-link { color: #fff; }
    .sidebar .nav-link.active,
    .sidebar .nav-link:hover { background-color: #1f3e63; }
    .hide-on-collapse { transition: opacity 0.3s; }
    .sidebar.collapsed .hide-on-collapse { opacity: 0; }
    .toggle-btn {
      background: none;
      border: none;
      color: #fff;
      width: 100%;
      text-align: right;
      padding: 0.5rem;
    }
    .content {
      margin-left: 220px;
      padding: 70px 20px 20px;
      transition: margin-left 0.3s;
    }
    .sidebar.collapsed ~ .content {
      margin-left: 60px;
    }
  </style>
</head>

<body>
  <!-- Nav Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ url('/home') }}">ARCHIVA</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
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
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column flex-shrink-0">
      <button class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-chevron-left"></i>
      </button>

      <div class="nav flex-column mt-2">
        <a
          href="{{ url('/home') }}"
          class="nav-link d-flex align-items-center p-3 {{ request()->is('home') ? 'active' : '' }}"
        >
          <i class="fas fa-home me-3"></i>
          <span class="hide-on-collapse">Dashboard</span>
        </a>

        @if(auth()->user()->role && in_array(auth()->user()->role->nombre_rol, ['admin','archivista']))
          <a
            href="{{ route('inventarios.transferencias.index') }}"
            class="nav-link d-flex align-items-center p-3 {{ request()->is('inventarios/transferencias*') ? 'active' : '' }}"
          >
            <i class="fas fa-archive me-3"></i>
            <span class="hide-on-collapse">Transferencias</span>
          </a>
        @endif

        <a
          href="{{ route('prestamos.index') }}"
          class="nav-link d-flex align-items-center p-3 {{ request()->is('prestamos*') ? 'active' : '' }}"
        >
          <i class="fas fa-book me-3"></i>
          <span class="hide-on-collapse">Préstamos</span>
        </a>

        @if(auth()->user()->role && auth()->user()->role->nombre_rol == 'admin')
          <a
            href="{{ route('admin.users.index') }}"
            class="nav-link d-flex align-items-center p-3 {{ request()->is('admin/users*') ? 'active' : '' }}"
          >
            <i class="fas fa-users me-3"></i>
            <span class="hide-on-collapse">Usuarios</span>
          </a>
        @endif

        @if(auth()->user()->role && in_array(auth()->user()->role->nombre_rol, ['admin','archivista']))
          <a
            href="{{ route('inventarios.dependencias.index') }}"
            class="nav-link d-flex align-items-center p-3 {{ request()->is('inventarios/dependencias*') ? 'active' : '' }}"
          >
            <i class="fas fa-building me-3"></i>
            <span class="hide-on-collapse">Dependencias</span>
          </a>
        @endif
      </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="content flex-fill">
      <div class="container-fluid">
        {{ $slot }}
      </div>
    </main>
  </div>

  <x-alert-modal />

  <!-- Bootstrap 5.3 Bundle JS (incluye Popper) -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"
  ></script>

  <!-- Feather Icons (opcional) -->
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    feather.replace();

    function toggleSidebar() {
      const sidebar    = document.querySelector('.sidebar');
      const icon       = sidebar.querySelector('.toggle-btn i');
      sidebar.classList.toggle('collapsed');
      icon.classList.toggle('fa-chevron-right');
      icon.classList.toggle('fa-chevron-left');
    }
  </script>

  @stack('scripts')
</body>
</html>
