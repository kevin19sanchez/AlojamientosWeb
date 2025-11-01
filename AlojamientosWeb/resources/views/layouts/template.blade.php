<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Verde Estancia')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Asegura que el footer se quede abajo */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-tree text-success me-2" aria-hidden="true"></i>
                    Verde Estancia
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}" aria-label="Ver estancias">Estancias</a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reserva.index') }}" aria-label="Mis Reservas">Mis Reservas</a>
                            </li>
                        @endauth

                        @auth
                            @if(auth()->user()->is_superadmin)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('index.lodging') }}" aria-label="Crear alojamiento">
                                        <i class="fas fa-plus-circle me-1"></i>Crear Alojamiento
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                    <div class="ms-3">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary me-2" aria-label="Iniciar sesión">Iniciar Sesión</a>
                            <a href="{{ route('register') }}" class="btn btn-success" aria-label="Crear una cuenta">Registrarse</a>
                        @else
                            <div class="dropdown">
                                <button class="btn btn-outline-success dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ auth()->user()->nombre_completo }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-4">
        @yield('content')
    </main>

    <footer class="bg-light border-top">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h2 class="h5">Verde Estancia</h2>
                    <p class="text-muted">Tu lugar ideal para descansar en contacto con la naturaleza.</p>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <h3 class="h6">Enlaces</h3>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-decoration-none text-muted">Estancias</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h3 class="h6">Redes sociales</h3>
                    <div>
                        <a href="#" class="text-muted me-3" aria-label="Facebook">
                            <i class="fab fa-facebook-f" aria-hidden="true"></i>
                        </a>
                        <a href="#" class="text-muted me-3" aria-label="Instagram">
                            <i class="fab fa-instagram" aria-hidden="true"></i>
                        </a>
                        <a href="#" class="text-muted" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center text-muted pt-3 border-top mt-4">
                &copy; {{ date('Y') }} Verde Estancia. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!--
<a href="{{-- route('login') --}}" class="btn btn-outline-secondary me-2" aria-label="Iniciar sesión">Iniciar Sesión</a>
<a href="{{-- route('register') --}}" class="btn btn-success" aria-label="Crear una cuenta">Registrarse</a>

-->
