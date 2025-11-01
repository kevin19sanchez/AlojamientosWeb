@extends('layouts.template')

@section('title', 'Registro')

@section('content')
<div class="container">
    @if (session('mensaje'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Errores:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h5 class="fw-bold">Verde Estancia</h5>
                        <p class="text-muted">Únete a Verde Estancia y reserva tu estancia ideal.</p>
                    </div>

                    <form method="POST" action="{{ route('create.user') }}">
                        @csrf

                        <!-- Fila 1: Nombre completo y Teléfono -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre_completo" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" placeholder="Ingresa tu nombre completo" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ingresa tu teléfono" required>
                            </div>
                        </div>

                        <!-- Fila 2: Correo y Toggle de Superadmin -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label d-block">¿Eres admin?</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="esSuperadminToggle">
                                    <label class="form-check-label" for="esSuperadminToggle">Poner clave secreta</label>
                                </div>
                                <small class="text-muted">Solo si tienes autorización</small>
                            </div>
                        </div>

                        <!-- Campo de clave secreta (oculto por defecto) -->
                        <div class="row mb-3 d-none" id="adminKeyField">
                            <div class="col-12">
                                <label for="clave_secreta" class="form-label">Clave de secreta</label>
                                <input type="password" class="form-control" id="clave_secreta" name="clave_secreta" placeholder="Ingresa la clave secreta">
                                <small class="text-muted">Esta clave es confidencial. Solo el administrador la conoce.</small>
                            </div>
                        </div>

                        <!-- Fila 3: Contraseña y Confirmación -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Crea una contraseña" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Mínimo 8 caracteres</small>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirma tu contraseña" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 mb-3">Crear cuenta</button>

                        <p class="text-center text-muted small">
                            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-decoration-none">Inicia sesión</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Script para alternar visibilidad de contraseñas -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleSwitch = document.getElementById('esSuperadminToggle');
        const adminKeyField = document.getElementById('adminKeyField');
        const adminKeyInput = document.getElementById('admin_key');

        // Alternar visibilidad de contraseñas
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
        const passwordConfirm = document.querySelector('#password_confirmation');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }

        if (togglePasswordConfirm && passwordConfirm) {
            togglePasswordConfirm.addEventListener('click', function () {
                const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirm.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }

        // Alternar campo de clave secreta con el switch
        if (toggleSwitch) {
            toggleSwitch.addEventListener('change', function () {
                if (this.checked) {
                    adminKeyField.classList.remove('d-none');
                } else {
                    adminKeyField.classList.add('d-none');
                    if (adminKeyInput) adminKeyInput.value = '';
                }
            });
        }
    });
</script>
@endsection


