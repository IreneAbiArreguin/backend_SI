<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistema Admin')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    @stack('styles')
    <style>
        .map-card { height: calc(100vh - 200px); }
        #map { width:100%; height:100%; }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('mapa') }}" class="nav-link">Mapa</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('refugios') }}" class="nav-link">Refugios</a>
            </li>
            
        </ul>

      <!-- Navbar - Lado derecho -->
        <ul class="navbar-nav ml-auto">
            @auth
                <!-- Usuario autenticado -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user"></i> {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog mr-2"></i>Mi Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </li>
            @else
        
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i> Registrarse
                    </a>
                </li>
            @endauth
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-light-info elevation-4">
        <a href="{{ route('welcome') }}" class="brand-link">
            <img src="{{ asset('image/logo.png') }}" 
                 alt="Logo" 
                 class="brand-image img-circle elevation-3" 
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Yáanal Ha'</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-circle fa-2x" style="color:rgb(41, 40, 40) !important;"></i>
                </div>
                <div class="info">
                    @auth
                        <a href="#" class="d-block">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</a>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    @else
                        <a href="{{ route('login') }}" class="d-block">Iniciar Sesión</a>
                    @endauth
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('welcome') }}" class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            <p>Alertas</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('mapa') }}" class="nav-link {{ request()->routeIs('mapa') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map"></i>
                            <p>Mapa</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('refugios') }}" class="nav-link {{ request()->routeIs('refugios') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Refugios</p>
                        </a>
                    </li>
                    
                    @auth
                    <!-- Opciones solo para usuarios autenticados -->
                   <li class="nav-item">
                        <a href="{{ Auth::check() ? route('reportes.index') : route('login') }}" 
                        class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                            <i class="fa-solid fa-pencil"></i>
                            <p>{{ Auth::check() ? 'Mis Reportes' : 'Reportes' }}</p>
                        </a>
                    </li>
                    @endauth
                    
                    <li class="nav-item">
                        <a href="{{ route('informacion') }}" class="nav-link">
                            <i class="fa-solid fa-circle-info"></i>
                            <p>Acerca de</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Resto del código igual -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Página Principal')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block"><b>Versión</b> 1.0.0</div>
        <strong>Copyright &copy; 2024 Sistema Monitoreo Inundaciones.</strong> Todos los derechos reservados.
    </footer>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>