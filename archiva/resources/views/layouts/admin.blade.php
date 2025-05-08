<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Panel de Administración' }}</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <style>
    /* Sidebar styles */
    .sidebar {
      height: 100vh;
      position: fixed;
      top: 56px;
      /* Altura del navbar */
      left: 0;
      width: 220px;
      background-color: #2E5077;
      color: #fff;
      transition: width 0.3s;
      overflow: hidden;
    }

    .sidebar.collapsed {
      width: 60px;
    }

    .sidebar .nav-link {
      color: #fff;
    }

    .sidebar .nav-link:hover {
      background-color: #2E5077;
    }

    .hide-on-collapse {
      transition: opacity 0.3s;
    }

    .sidebar.collapsed .hide-on-collapse {
      opacity: 0;
    }

    .toggle-btn {
      background: none;
      border: none;
      color: #fff;
      width: 100%;
      text-align: right;
      padding: 0.5rem;
    }

    .profile-section {
      background-color: #495057;
    }

    /* Contenido principal */
    .content {
      margin-left: 220px;
      padding: 60px 20px 20px 20px;
      transition: margin-left 0.3s;
    }

    .sidebar.collapsed~.content {
      margin-left: 60px;
    }
  </style>
</head>

<body>
  <!-- Nav Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="{{ url('/home') }}">ARCHIVA</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/perfil') }}">Perfil</a>
        </li>
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="form-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger">Salir</button>
          </form>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Wrapper para Sidebar y Contenido -->
  <div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar d-flex flex-column flex-shrink-0">
      <button class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-chevron-left"></i>
      </button>
      <div class="nav flex-column">
        <!-- Dashboard -->
        <a href="{{ url('/home') }}" class="sidebar-link nav-link active text-decoration-none p-3">
          <i class="fas fa-home me-3"></i>
          <span class="hide-on-collapse">Dashboard</span>
        </a>

        <!-- Transferencias: solo admin y archivista -->
        @if(auth()->user()->role && in_array(auth()->user()->role->nombre_rol, ['admin', 'archivista']))
        <a href="{{ route('inventarios.transferencias.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('inventarios/transferencias*') ? 'active' : '' }}">
          <i class="fas fa-archive me-3"></i>
          <span class="hide-on-collapse">Transferencias</span>
        </a>
        @endif

        <!-- Préstamos: todos los roles -->
        <a href="{{ route('prestamos.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
          <i class="fas fa-book me-3"></i>
          <span class="hide-on-collapse">Préstamos</span>
        </a>

        <!-- Usuarios: solo admin -->
        @if(auth()->user()->role && auth()->user()->role->nombre_rol == 'admin')
        <a href="{{ route('admin.users.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('admin/users*') ? 'active' : '' }}">
          <i class="fas fa-users me-3"></i>
          <span class="hide-on-collapse">Usuarios</span>
        </a>
        @endif

        <a href="{{ route('prestamos.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
          <i class="fa-solid fa-diagram-project"></i>
          <span class="hide-on-collapse">Dependencias</span>
        </a>

        <a href="{{ route('prestamos.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
          <i class="fas fa-book me-3"></i>
          <span class="hide-on-collapse">ubicacíon</span>
        </a>


        <a href="{{ route('prestamos.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
          <i class="fa-solid fa-clone"></i>
          <span class="hide-on-collapse">Series</span>
        </a>

        <a href="{{ route('prestamos.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
          <i class="fa-solid fa-clone"></i>
          <span class="hide-on-collapse">Subseries</span>
        </a>

        <a href="{{ route('prestamos.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
          <i class="fas fa-book me-3"></i>
          <span class="hide-on-collapse">Tipo Documental</span>
        </a>

        <a href="{{ route('prestamos.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
          <i class="fa-solid fa-compact-disc"></i>
          <span class="hide-on-collapse">Soportes</span>
        </a>

        <a href="{{ route('prestamos.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
          <i class="fa-solid fa-table-cells-column-lock"></i>
          <span class="hide-on-collapse">Tabla de retención</span>
        </a>

        <a href="{{ route('prestamos.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
          <i class="fa-solid fa-folder-tree"></i>
          <span class="hide-on-collapse">Clasificacíon documental</span>
        </a>

        <a href="{{ route('prestamos.index') }}"
          class="sidebar-link nav-link p-3 {{ request()->is('prestamos*') ? 'active' : '' }}">
          <i class="fa-solid fa-user"></i>
          <span class="hide-on-collapse">Roles</span>
        </a>
      </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="content flex-fill">
      <div class="container-fluid">
        {{ $slot }}
      </div>
    </main>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    feather.replace();

    function toggleSidebar() {
      const sidebar = document.querySelector('.sidebar');
      const toggleIcon = document.querySelector('.toggle-btn i');
      sidebar.classList.toggle('collapsed');
      if (sidebar.classList.contains('collapsed')) {
        toggleIcon.classList.remove('fa-chevron-left');
        toggleIcon.classList.add('fa-chevron-right');
      } else {
        toggleIcon.classList.remove('fa-chevron-right');
        toggleIcon.classList.add('fa-chevron-left');
      }
    }
  </script>

</body>

</html>