@extends('layouts.template')

@section('title', 'Reseñas')

@section('content')
<main class="container my-4">
    <section class="mb-5">
        <h1 class="display-5 fw-bold mb-4">
            <i class="fas fa-star text-warning me-2"></i>
            Reseñas del Alojamiento: <span class="text-primary">{{ $alojamiento->nombre }}</span>
        </h1>

        @auth
            <a href="{{ route('home', $alojamiento->id) }}" class="btn btn-outline-secondary mb-4">
                <i class="fas fa-arrow-left me-1"></i> Volver al alojamiento
            </a>
        @endauth

        @if (session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($reseñas as $reseña)
                <article class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <h5 class="mb-1">{{ $reseña->usuario->nombre_completo ?? 'Usuario' }}</h5>
                                <small class="text-muted">
                                    {{ $reseña->fecha_comentario ? $reseña->fecha_comentario->diffForHumans() : 'Fecha no disponible' }}
                                </small>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $reseña->puntuacion)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    @php
                                        $puntaje = $reseña->puntuacion * 2;
                                        if ($puntaje >= 8.5) {
                                            $badge = 'bg-success';
                                            $texto = 'Excelente';
                                        } elseif ($puntaje >= 7) {
                                            $badge = 'bg-success';
                                            $texto = 'Muy bien';
                                        } elseif ($puntaje >= 6) {
                                            $badge = 'bg-warning text-dark';
                                            $texto = 'Bueno';
                                        } else {
                                            $badge = 'bg-danger';
                                            $texto = 'Regular';
                                        }
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ number_format($puntaje, 1) }} {{ $texto }}</span>
                                </div>
                            </div>
                            <p class="card-text flex-grow-1">
                                {{ $reseña->comentario }}
                            </p>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                        <h3 class="h5">No hay reseñas aún</h3>
                        <p class="text-muted">Sé el primero en dejar una reseña.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Paginación (solo si usas ->paginate()) --}}
        {{-- @if(isset($reseñas) && $reseñas instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <nav aria-label="Paginación de reseñas" class="mt-4">
                {{ $reseñas->links() }}
            </nav>
        @endif --}}
    </section>

    <!-- Formulario para agregar reseña -->
    @auth
        <section class="bg-light p-4 rounded">
            <h2 class="h4 mb-4">
                <i class="fas fa-pen-alt me-2"></i>
                Deja tu reseña
            </h2>

            <form action="{{ route('review.create') }}" method="POST">
                @csrf
                <input type="hidden" name="id_alojamiento" value="{{ $alojamiento->id }}">

                <div class="mb-3">
                    <label class="form-label">Tu puntuación</label>
                    <div class="d-flex flex-wrap">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-check form-check-inline me-3 mb-2">
                                <input type="radio" class="btn-check" name="puntuacion" id="star{{ $i }}" value="{{ $i }}" autocomplete="off" required>
                                <label class="btn btn-outline-warning" for="star{{ $i }}">
                                    <i class="fas fa-star"></i> {{ $i }}
                                </label>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentario</label>
                    <textarea name="comentario" id="comentario" class="form-control" rows="5" placeholder="Cuéntanos tu experiencia..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-1"></i> Enviar reseña
                </button>
            </form>
        </section>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-user me-2"></i>
            <a href="{{ route('login') }}" class="alert-link">Inicia sesión</a> para dejar una reseña.
        </div>
    @endauth
</main>
@endsection
