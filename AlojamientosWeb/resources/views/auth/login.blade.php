@extends('layouts.template')

@section('title', 'Inicio de Sesion')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="row g-0">
                    <!-- Imagen -->
                    <div class="col-md-6 d-none d-md-block">
                        <img src="{{ asset('images/login.jpg') }}" class="img-fluid h-100 object-fit-cover" alt="Fondo de bosque y cabaña" style="border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                    </div>

                    <!-- Formulario -->
                    <div class="col-md-6 p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold">Verde Estancia</h5>
                        </div>

                        <p class="text-muted mb-4">Bienvenido de nuevo</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                                {{-- <a href="#" class="text-decoration-none text-muted mt-1 d-block">¿Olvidaste tu contraseña?</a> --}}
                            </div>
                            <button type="submit" class="btn btn-success w-100 mb-3">Iniciar Sesión</button>

                            <div class="text-center my-3">
                                <span class="text-muted">o</span>
                            </div>

                            <button type="button" class="btn btn-outline-secondary w-100 mb-3">
                                <i class="fab fa-google me-2"></i> Iniciar sesión con Google
                            </button>

                            <p class="text-center text-muted small">
                                ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-decoration-none">Regístrate</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
