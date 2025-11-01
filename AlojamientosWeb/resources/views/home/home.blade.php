@extends('layouts.template')

@section('title', '')

@section('content')
<!-- Sección Hero con Imagen de Fondo usando <img> -->
<section class="hero-section py-5 position-relative">
    <!-- Imagen de fondo -->
    <img src="{{ asset('images/portada.jpg') }}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover z-index-0" alt="Bosque">

    <!-- Overlay oscuro para mejorar legibilidad -->
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50 z-index-1"></div>

    <!-- Contenido principal -->
    <div class="container text-white text-center position-relative z-index-2">
        <h1 class="display-4 fw-bold">Encuentra tu Escapada Perfecta</h1>
        <p class="lead mb-4">Descubre los destinos más bellos del mundo.</p>
        <form class="search-form mt-4">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="¿A dónde quieres ir?" aria-label="Destino">
                <input type="date" class="form-control" placeholder="Check-in" aria-label="Check-in">
                <input type="date" class="form-control" placeholder="Check-out" aria-label="Check-out">
                <select class="form-select" aria-label="Huéspedes">
                    <option selected>Huéspedes</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4+</option>
                </select>
                <button class="btn btn-success" type="submit">Buscar</button>
            </div>
        </form>
    </div>
</section>

<!-- Sección Alojamientos -->
<section class="trending-destinations py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3">Destinos Destacados</h2>
            {{-- <a href="#" class="btn btn-link">Ver todo</a> --}}
        </div>
        <div class="row g-4">
            <!-- Tarjeta 1 -->
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="{{ asset('images/kyoto.webp') }}" class="card-img-top" alt="Kyoto, Japón">
                    <div class="card-body">
                        <h5 class="card-title">Kyoto, Japón</h5>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 2 -->
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="{{ asset('images/amalfi-coast.webp') }}" class="card-img-top" alt="Costa Amalfitana, Italia">
                    <div class="card-body">
                        <h5 class="card-title">Costa Amalfitana, Italia</h5>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 3 -->
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="{{ asset('images/santorini.webp') }}" class="card-img-top" alt="Santorini, Grecia">
                    <div class="card-body">
                        <h5 class="card-title">Santorini, Grecia</h5>
                    </div>
                </div>
            </div>
            <!-- Tarjeta 4 -->
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="{{ asset('images/ubud.webp') }}" class="card-img-top" alt="Ubud, Bali">
                    <div class="card-body">
                        <h5 class="card-title">Ubud, Bali</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección Hoteles Destacados -->
<section class="featured-accommodations py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3">Alojamientos Disponibles</h2>
        </div>

        @if($viewlodging->isEmpty())
            <div class="text-center py-5">
                <p class="text-muted">No hay alojamientos disponibles en este momento.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($viewlodging as $alojamiento)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ route('detail.show', $alojamiento->id) }}" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow-sm border-0 hover-shadow">
                                @if($alojamiento->imagen)
                                    <img src="{{ asset('storage/' . $alojamiento->imagen) }}" class="card-img-top" alt="{{ $alojamiento->nombre }}">
                                @else
                                    <img src="{{ urlencode($alojamiento->nombre) }}" class="card-img-top" alt="{{ $alojamiento->nombre }}">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $alojamiento->nombre }}</h5>
                                    <p class="card-text"><small class="text-muted">{{ $alojamiento->ubicacion }}</small></p>
                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star me-1"></i>
                                            {{ $alojamiento->reseñas_avg_puntuacion ? number_format($alojamiento->reseñas_avg_puntuacion, 1) : 'Sin reseñas' }}
                                        </span>
                                        <span class="fw-bold">${{ number_format($alojamiento->precio, 0, ',', '.') }} / noche</span>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 p-2">
                                    <small class="text-muted d-block text-center">Selecciona fechas al reservar</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
