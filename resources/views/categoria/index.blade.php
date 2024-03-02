@extends('template')

@section('title', ' Categorias')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
@if (session('success'))
    <script>
        let message = "{{ session('success')}}"
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
        <h1 class="mt-4 text-center">Categorías</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Categorias</li>
        </ol>

        <a href="{{ route('categorias.create')}}"><button type="button" class="btn btn-primary mb-4">Añadir nueva categoria</button></a>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-tag"></i>
                Categorias
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td>{{$categoria->nombre}}</td>
                                <td>{{$categoria->descripcion}}</td>
                                <td>
                                    @if ($categoria->estado == 1)
                                        <span class="fw-bolder p-2 rounded bg-success text-white">Activo</span>
                                    @else
                                    <span class="fw-bolder p-2 rounded bg-danger text-white">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <form action="{{ route('categorias.edit', ['categoria' => $categoria]) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-warning">Editar</button>
                                        </form>

                                        @if ($categoria->estado == 1)
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $categoria->id }}">Eliminar</button>
                                        @else
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $categoria->id }}">Restaurar</button>
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal-{{ $categoria->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $categoria->estado == 1 ? 'Seguro quieres eliminar la categoría?' : 'Seguro quieres restaurar la categoría?'}}
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('categorias.destroy', ['categoria' => $categoria->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
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