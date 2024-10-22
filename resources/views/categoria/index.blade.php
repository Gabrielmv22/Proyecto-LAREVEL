@extends('template')

@section('title','categorias')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <style>
        /* Estilo cebra para la tabla */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2; /* Color de fondo claro para filas impares */
        }
        .table-striped tbody tr:hover {
            background-color: #d1ecf1; /* Color de fondo al pasar el mouse */
        }
        .table thead th {
            background-color: #007bff; /* Color de fondo de la cabecera */
            color: white; /* Color del texto de la cabecera */
        }
    </style>
@endpush

@section('content')
    @if(session('success'))
        <script>
            let message ="{{ session('success')}}";
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: message
            });
        </script>
    @endif

    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Categorias</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
            <li class="breadcrumb-item active">Categoria</li>
        </ol>
        <div class="mb-4">
            <a href="{{route('categorias.create')}}">
                <button type="button" class="btn btn-primary">Añadir nuevo registro</button>
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Categorias
            </div>
            <div class="card-body">
                <table class="table table-striped" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($categorias as $categoria)
                          <tr>  
                              <td>
                                  {{$categoria->caracteristica->nombre}}
                              </td>
                              <td>
                                  {{$categoria->caracteristica->descripcion}} <!-- Asumiendo que tienes esta columna -->
                              </td>
                              <td>

                                    @if($categoria->caracteristica->estado == 1)
                                    <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>


                                    @else
                                    <span class="fw-bolder p-1 rounded bg-danger text-white">Inactivo</span>
                                    @endif
                              </td>
                              <td>
                              <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{route('categorias.edit',['categoria'=>$categoria])}}" method="get">
                                
                                <button type="submit" class="btn btn-warning">Editar</button>
                               
                                 </form>
                                 @if($categoria->caracteristica->estado ==1)  
                                 <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$categoria->id}}">Eliminar</button>
                                 @else      
                                 <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$categoria->id}}">Restaurar</button>
                                @endif       
                                            
                                            </div>
                              </td>

                          </tr>
                          <!-- Modal -->
<div class="modal fade" id="confirmModal-{{$categoria->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmacion</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{$categoria->caracteristica->estado ==1 ? '¿Segur@ que quieres Eliminar esta categoria?' : '¿Segur@ que quieres Restaurar esta categoria?'}}
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <form action="{{route('categorias.destroy',['categoria'=>$categoria->id]) }}" method="post">
            @method('DELETE')
            @csrf
        <button type="submit" class="btn btn-primary">Confirmar</button>
        </form>
      </div>
    </div>
  </div>
</div>
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
