@extends('layouts.template')

@section('title', 'Mis Reservas')

@section('content')
<main class="container my-4">
    <header class="mb-4">
        <h1 class="h2">
            <i class="fas fa-user-circle text-primary me-2"></i> Mis reservas activas
        </h1>
    </header>

    @if(session('mensaje'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if($viewreservas->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
            <h3 class="h5">No tienes reservas activas</h3>
            <p class="text-muted">Explora nuestros alojamientos y haz tu primera reserva.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-2">
                <i class="fas fa-home me-1"></i> Explorar alojamientos
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach($viewreservas as $reserva)
                @php
                    $alojamiento = $reserva->alojamiento;
                    $modalId = 'modal-' . $reserva->id;
                @endphp

                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @if($alojamiento)
                                <div class="d-flex flex-column flex-md-row gap-3">
                                    @if($alojamiento->imagen)
                                        <img src="{{ asset('storage/' . $alojamiento->imagen) }}"
                                            alt="{{ $alojamiento->nombre }}"
                                            class="img-fluid rounded"
                                            style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                            <i class="fas fa-home text-muted fa-2x"></i>
                                        </div>
                                    @endif

                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-2">{{ $alojamiento->nombre }}</h5>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-map-marker-alt me-1"></i> {{ $alojamiento->ubicacion }}
                                        </p>
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <p class="mb-1">
                                                    <i class="fas fa-calendar-check text-success me-1"></i>
                                                    <strong>Check-in:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}
                                                </p>
                                                <p class="mb-1">
                                                    <i class="fas fa-calendar-times text-danger me-1"></i>
                                                    <strong>Check-out:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_fin)->format('d/m/Y') }}
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1">
                                                    <i class="fas fa-bed me-1"></i>
                                                    <strong>Noches:</strong> {{ $reserva->fecha_inicio->diffInDays($reserva->fecha_fin) }}
                                                </p>
                                                <p class="mb-1">
                                                    <i class="fas fa-dollar-sign me-1"></i>
                                                    <strong>Total:</strong> ${{ number_format($reserva->precio_total, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column justify-content-end">
                                        <!-- Botón que abre el modal de cancelación -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                            <i class="fas fa-trash-alt me-1"></i> Cancelar
                                        </button>
                                    </div>
                                </div>

                                <!-- Modal de cancelación (uno por reserva) -->
                                <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="modalLabel{{ $reserva->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $reserva->id }}">
                                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>Confirmar cancelación
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas cancelar tu reserva en <strong>{{ $alojamiento->nombre }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('reserva.delete', $reserva) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Sí, cancelar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Alojamiento eliminado -->
                                <div class="d-flex align-items-center">
                                    <div class="bg-light d-flex align-items-center justify-content-center me-3" style="width: 120px; height: 120px;">
                                        <i class="fas fa-exclamation-triangle text-warning fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5 class="card-title text-muted">Alojamiento no disponible</h5>
                                        <p class="text-muted small">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Este alojamiento ha sido eliminado, pero la reserva se mantiene en tu historial.
                                        </p>
                                        <!-- Botón que abre el modal de eliminación -->
                                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                                            <i class="fas fa-trash-alt me-1"></i> Eliminar reserva
                                        </button>

                                        <!-- Modal de eliminación (uno por reserva) -->
                                        <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="modalLabel{{ $reserva->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel{{ $reserva->id }}">
                                                            <i class="fas fa-trash-alt text-secondary me-2"></i>Eliminar reserva
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Deseas eliminar esta reserva del historial?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <form action="{{ route('reserva.delete', $reserva) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-secondary">Sí, eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
