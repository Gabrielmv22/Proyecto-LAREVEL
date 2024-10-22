@extends('template')

@section('title', 'Marcas')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Marcas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Marcas</li>
        </ol>
        <div class="mb-4">
            <a href="{{ route('marcas.create') }}">
                <button type="button" class="btn btn-primary">Añadir nueva marca</button>
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Marcas
            </div>
            <div class="card-body">
                <table class="table table-striped" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($marcas as $marca)
                            <tr>
                                <td>{{ $marca->caracteristica->nombre }}</td>
                                <td>{{ $marca->caracteristica->descripcion }}</td>
                                <td>
                                    @if ($marca->caracteristica->estado == 1)
                                        <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                                    @else
                                        <span class="fw-bolder p-1 rounded bg-danger text-white">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('marcas.edit', ['marca' => $marca]) }}" method="get">
                                        <button type="submit" class="btn btn-warning">Editar</button>
                                    </form>
                                    @if ($marca->caracteristica->estado == 1)
                                        <form action="{{ route('marcas.destroy', ['marca' => $marca->id]) }}" method="post" style="display:inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    @else
                                        <form action="{{ route('marcas.destroy', ['marca' => $marca->id]) }}" method="post" style="display:inline;">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-success">Restaurar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>
@endpush
