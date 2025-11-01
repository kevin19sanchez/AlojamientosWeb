@extends('layouts.template')

@section('title', 'Crear Alojamientos')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Gestión de Alojamientos</h1>

    {{-- Formulario 1: Crear Tipo de Alojamiento --}}
    <section class="mb-5">
        @if (session('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h2 class="h4 mb-3">Crear Tipo Alojamiento</h2>
        <form action="{{ route('create.typelodging') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre_alojamiento" class="form-label">Nombre del Tipo</label>
                    <input type="text"
                            class="form-control @error('nombre_alojamiento') is-invalid @enderror"
                            id="nombre_alojamiento"
                            name="nombre_alojamiento"
                            value="{{ old('nombre_alojamiento') }}"
                            required>
                    @error('nombre_alojamiento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Crear Tipo</button>
                </div>
            </div>
        </form>
    </section>

    {{-- Tabla 1: Tipos de Alojamiento --}}
    <section class="mb-5">
        <h2 class="h4 mb-3">Tipos de Alojamiento Registrados</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($viewtypelodging as $tipo)
                        <tr>
                            <td>{{ $tipo->id }}</td>
                            <td>{{ $tipo->nombre_alojamiento }}</td>
                            <td>
                                <!-- Botones de acción -->
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTipoModal{{ $tipo->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteTipoModal{{ $tipo->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Editar Tipo --}}
                        <div class="modal fade" id="editTipoModal{{ $tipo->id }}" tabindex="-1" aria-labelledby="editTipoModalLabel{{ $tipo->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('edit.typelodging', $tipo->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editTipoModalLabel{{ $tipo->id }}">Editar Tipo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="edit_nombre_alojamiento{{ $tipo->id }}" class="form-label">Nombre</label>
                                                <input type="text"
                                                        class="form-control"
                                                        id="edit_nombre_alojamiento{{ $tipo->id }}"
                                                        name="nombre_alojamiento"
                                                        value="{{ $tipo->nombre_alojamiento }}"
                                                        required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Eliminar Tipo --}}
                        <div class="modal fade" id="deleteTipoModal{{ $tipo->id }}" tabindex="-1" aria-labelledby="deleteTipoModalLabel{{ $tipo->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('delete.typelodging', $tipo->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title text-danger" id="deleteTipoModalLabel{{ $tipo->id }}">Eliminar Tipo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de eliminar el tipo "<strong>{{ $tipo->nombre_alojamiento }}</strong>"? Esta acción no se puede deshacer.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No hay tipos de alojamiento registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Formulario 2: Crear Alojamiento --}}
    <section class="mb-5">
        <h2 class="h4 mb-3">Crear Alojamiento</h2>
        <form action="{{ route('create.alojamineto') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text"
                            class="form-control @error('nombre') is-invalid @enderror"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="ubicacion" class="form-label">Ubicación</label>
                    <input type="text"
                            class="form-control @error('ubicacion') is-invalid @enderror"
                            id="ubicacion"
                            name="ubicacion"
                            value="{{ old('ubicacion') }}"
                            required>
                    @error('ubicacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number"
                            step="0.01"
                            class="form-control @error('precio') is-invalid @enderror"
                            id="precio"
                            name="precio"
                            value="{{ old('precio') }}"
                            required>
                    @error('precio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="capacidad" class="form-label">Capacidad</label>
                    <input type="number"
                            class="form-control @error('capacidad') is-invalid @enderror"
                            id="cpacidad"
                            name="cpacidad"
                            value="{{ old('capacidad') }}"
                            required>
                    @error('capacidad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="id_tipo_alojamiento" class="form-label">Tipo de Alojamiento</label>
                    <select class="form-select @error('id_tipo_alojamiento') is-invalid @enderror"
                            id="id_tipo_alojamiento"
                            name="id_tipo_alojamiento"
                            required>
                        <option value="">Seleccionar tipo</option>
                        @foreach($idtypelodging as $tipo)
                            <option value="{{ $tipo->id }}" {{ old('id_tipo_alojamiento') == $tipo->id ? 'selected' : '' }}>
                                {{ $tipo->nombre_alojamiento }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_tipo_alojamiento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file"
                        class="form-control @error('imagen') is-invalid @enderror"
                        id="imagen"
                        name="imagen"
                        accept="image/*">
                    <div class="form-text">Formatos permitidos: JPG, PNG, GIF (máx. 2MB)</div>
                    @error('imagen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                id="descripcion"
                                name="descripcion"
                                rows="3">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input"
                                type="checkbox"
                                id="disponible"
                                name="disponible"
                                value="1"
                                {{ old('disponible') ? 'checked' : '' }}>
                        <label class="form-check-label" for="disponible">
                            Disponible
                        </label>
                    </div>
                </div> --}}

                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Crear Alojamiento</button>
                </div>
            </div>
        </form>
    </section>

    {{-- Tabla 2: Alojamientos --}}
    <section>
        <h2 class="h4 mb-3">Alojamientos Registrados</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Precio</th>
                        <th>Capacidad</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($viewalojamiento as $alojamiento)
                        <tr>
                            <td>{{ $alojamiento->id }}</td>
                            <td>{{ $alojamiento->nombre }}</td>
                            <td>{{ $alojamiento->ubicacion }}</td>
                            <td>{{ number_format($alojamiento->precio, 2) }}</td>
                            <td>{{ $alojamiento->cpacidad }}</td>
                            <td>{{ $alojamiento->tipoAlojamiento->nombre_alojamiento ?? '—' }}</td>
                            <td>
                                <!-- Botones de acción -->
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editAlojamientoModal{{ $alojamiento->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                {{-- <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAlojamientoModal{{ $alojamiento->id }}">
                                    <i class="fas fa-trash"></i>
                                </button> --}}
                            </td>
                        </tr>

                        {{-- Modal Editar Alojamiento --}}
                        <div class="modal fade" id="editAlojamientoModal{{ $alojamiento->id }}" tabindex="-1" aria-labelledby="editAlojamientoModalLabel{{ $alojamiento->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('edit.alojamiento', $alojamiento->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editAlojamientoModalLabel{{ $alojamiento->id }}">Editar Alojamiento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="nombre{{ $alojamiento->id }}" class="form-label">Nombre</label>
                                                    <input type="text"
                                                            class="form-control"
                                                            id="nombre{{ $alojamiento->id }}"
                                                            name="nombre"
                                                            value="{{ $alojamiento->nombre }}"
                                                            required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="ubicacion{{ $alojamiento->id }}" class="form-label">Ubicación</label>
                                                    <input type="text"
                                                            class="form-control"
                                                            id="ubicacion{{ $alojamiento->id }}"
                                                            name="ubicacion"
                                                            value="{{ $alojamiento->ubicacion }}"
                                                            required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="precio{{ $alojamiento->id }}" class="form-label">Precio</label>
                                                    <input type="number"
                                                            step="0.01"
                                                            class="form-control"
                                                            id="precio{{ $alojamiento->id }}"
                                                            name="precio"
                                                            value="{{ $alojamiento->precio }}"
                                                            required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="cpacidad{{ $alojamiento->id }}" class="form-label">Capacidad</label>
                                                    <input type="number"
                                                            class="form-control"
                                                            id="cpacidad{{ $alojamiento->id }}"
                                                            name="cpacidad"
                                                            value="{{ $alojamiento->cpacidad }}"
                                                            required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="id_tipo_alojamiento{{ $alojamiento->id }}" class="form-label">Tipo</label>
                                                    <select class="form-select" name="id_tipo_alojamiento" required>
                                                        @foreach($viewtypelodging as $tipo)
                                                            <option value="{{ $tipo->id }}" {{ $alojamiento->id_tipo_alojamiento == $tipo->id ? 'selected' : '' }}>
                                                                {{ $tipo->nombre_alojamiento }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="imagen{{ $alojamiento->id }}" class="form-label">Imagen (dejar vacío para no cambiar)</label>
                                                    <input type="file"
                                                        class="form-control"
                                                        id="imagen{{ $alojamiento->id }}"
                                                        name="imagen"
                                                        accept="image/*">
                                                    <div class="form-text">
                                                        @if($alojamiento->imagen)
                                                            <img src="{{ Storage::url($alojamiento->imagen) }}"
                                                            alt="Vista previa"
                                                            class="img-thumbnail mt-2"
                                                            style="max-height: 100px;">
                                                        @else
                                                            Sin imagen
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <label for="descripcion{{ $alojamiento->id }}" class="form-label">Descripción</label>
                                                    <textarea class="form-control"
                                                                id="descripcion{{ $alojamiento->id }}"
                                                                name="descripcion"
                                                                rows="3">{{ $alojamiento->descripcion }}</textarea>
                                                </div>
                                                {{-- <div class="col-12">
                                                    <div class="form-check">
                                                        <input class="form-check-input"
                                                                type="checkbox"
                                                                id="disponible{{ $alojamiento->id }}"
                                                                name="disponible"
                                                                value="1"
                                                                {{ $alojamiento->disponible ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="edit_disponible{{ $alojamiento->id }}">
                                                            Disponible
                                                        </label>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Eliminar Alojamiento
                        <div class="modal fade" id="deleteAlojamientoModal{{ $alojamiento->id }}" tabindex="-1" aria-labelledby="deleteAlojamientoModalLabel{{ $alojamiento->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('delete.alojamiento', $alojamiento->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title text-danger" id="deleteAlojamientoModalLabel{{ $alojamiento->id }}">Eliminar Alojamiento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de eliminar el alojamiento "<strong>{{ $alojamiento->nombre }}</strong>"? Esta acción no se puede deshacer.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>--}}
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No hay alojamientos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
