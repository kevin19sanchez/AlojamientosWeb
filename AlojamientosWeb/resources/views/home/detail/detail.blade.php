@extends('layouts.template')

@section('title', 'Detalle')

@section('content')
<main class="container my-4">
    <nav aria-label="Navegación" class="mb-3">
        <ol class="breadcrumb">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary mb-4">
                <i class="fas fa-arrow-left me-1"></i> Volver al alojamiento
            </a>
        </ol>
    </nav>

    @if ( session('mensaje') )
        <div class="alert alert-success">{{ session('mensaje') }}</div>
    @endif

    <header class="mb-4">
        <h1 class="display-5 fw-bold">{{ $alojamientos->nombre }}</h1>
        <p class="lead text-muted">
            <i class="fas fa-map-marker-alt me-2"></i> {{ $alojamientos->ubicacion }}
        </p>
    </header>

    <section class="mb-5">
        <div class="row g-2">
            <div class="col-12 col-md-8 mb-2 mb-md-0">
                @if($alojamientos->imagen)
                    <img src="{{ asset('storage/' . $alojamientos->imagen) }}" alt="{{ $alojamientos->nombre }}" class="img-fluid rounded shadow">
                @else
                    <img src="{{ urlencode($alojamientos->nombre) }}" class="img-fluid rounded shadow" alt="{{ $alojamientos->nombre }}">
                @endif
            </div>
        </div>
    </section>

    <section class="row mb-5">
        <div class="col-lg-8">
            <h2 class="h4 mb-3">Descripción</h2>
            <p>{{ $alojamientos->descripcion ?? 'Descripción no disponible.' }}</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="h5 mb-3">Detalles</h3>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-user-friends text-primary me-2"></i>
                            <strong>Huéspedes:</strong> Hasta {{ $alojamientos->cpacidad ?? 'N/A' }}
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-bed text-primary me-2"></i>
                            <strong>Precio:</strong> ${{ number_format($alojamientos->precio, 0, ',', '.') }} / noche
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar-alt text-info me-2"></i>
                            <strong>Disponibilidad:</strong>
                            <span class="text-info">Verifica fechas al reservar</span>
                        </li>
                        <li class="mt-3">
                            <a href="{{ route('review.index', $alojamientos->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-comments me-1"></i> Ver Reseñas 
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @auth
        <div class="d-grid gap-2 d-md-block mb-5">
            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalReserva">
                <i class="fas fa-calendar-check me-2"></i>Reservar ahora
            </button>
        </div>
    @endauth

    <!-- Modal de reserva -->
    <div class="modal fade" id="modalReserva" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('reserva.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_alojamiento" value="{{ $alojamientos->id }}">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-calendar-check text-primary me-2"></i>Reservar alojamiento
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Confirmas la reserva de <strong>{{ $alojamientos->nombre }}</strong>?</p>
                        <div class="alert alert-info small">
                            <i class="fas fa-info-circle me-1"></i>
                            Precio: ${{ number_format($alojamientos->precio, 0, ',', '.') }} / noche
                        </div>
                        <div class="mb-3">
                            <label>Check-in</label>
                            <input type="date" name="fecha_inicio" class="form-control @error('fecha_inicio') is-invalid @enderror" required>
                            @error('fecha_inicio')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Check-out</label>
                            <input type="date" name="fecha_fin" class="form-control" required min="{{ now()->addDay()->format('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-1"></i> Confirmar reserva
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

{{-- @if($alojamientos->disponible)
                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalReserva">
                    <i class="fas fa-calendar-check me-2"></i>Reservar ahora
                </button>
            @else
                <button class="btn btn-secondary btn-lg" disabled>
                    <i class="fas fa-ban me-2"></i>No disponible
                </button>
            @endif --}}
