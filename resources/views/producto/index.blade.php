@extends('template')

@section('title', ' Productos')

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
        <h1 class="mt-4 text-center">Productos</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Productos</li>
        </ol>

        <a href="{{ route('productos.create')}}"><button type="button" class="btn btn-primary mb-4">Añadir nuevo producto</button></a>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-brands fa-product-hunt"></i>
                Productos
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Categoría</th>
                            <th>Nombre</th>
                            <th>Marca</th>
                            <!--<th>Descripcion</th>
                            <th>Stock</th>-->
                            <th>Codigo</th>
                            <!--<th>Fecha de vencimiento</th>
                            <th>Imagen</th>-->
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr>
                                <td>
                                    <div class="container">
                                        <div class="row">
                                            <span class="m-1 rounded-pill p-1 bg-secondary text-white text-center">{{$producto->categoria->nombre}}</span>
                                        </div>
                                    </div>
                                    
                                </td>
                                <td>{{$producto->nombre}}</td>
                                <td>{{$producto->marca}}</td>
                                <!--<td>{{$producto->descripcion}}</td>
                                <td>{{$producto->stock}}</td>-->
                                <td>{{$producto->codigo}}</td>
                                <!--<td>{{$producto->fecha_vencimiento}}</td>
                                <td>{{$producto->img_path}}</td>-->
                                
                                <td>
                                    @if ($producto->estado == 1)
                                        <span class="fw-bolder p-2 rounded bg-success text-white">Activo</span>
                                    @else
                                        <span class="fw-bolder p-2 rounded bg-danger text-white">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <form action="{{ route('productos.edit', ['producto' => $producto]) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-warning">Editar</button>
                                        </form>
                                        
                                            <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verModal-{{ $producto->id }}">Ver</button>
                                        @if ($producto->estado == 1)
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $producto->id }}">Eliminar</button>
                                        @else
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $producto->id }}">Restaurar</button>
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal eliminar-->
                            <div class="modal fade" id="exampleModal-{{ $producto->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{ $producto->estado == 1 ? 'Seguro quieres eliminar el producto?' : 'Seguro quieres restaurar el producto?'}}
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('productos.destroy', ['producto' => $producto->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Confirmar</button>
                                    </form>
                                    
                                    </div>
                                </div>
                                </div>
                            </div>

                            <!-- Modal ver-->
                            <div class="modal fade" id="verModal-{{ $producto->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detalle del producto</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Nombre:</span> {{ $producto->nombre =='' ? 'No tiene' : $producto->nombre}}</label>
                                            </div>

                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Descripción:</span> {{ $producto->descripcion =='' ? 'No tiene' : $producto->descripcion}}</label>
                                            </div>

                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Fecha vencimiento:</span> {{ $producto->fecha_vencimiento =='' ? 'No tiene' : $producto->fecha_vencimiento}}</label>
                                            </div>

                                            <div class="row mb-3">
                                                <label for=""><span class="fw-bolder">Stock:</span> {{ $producto->stock }}</label>
                                            </div>

                                            
                                                <div class="row mb-3">
                                                    <label for=""><span class="fw-bolder">Precio: $</span> {{ $producto->precio_venta }}</label>
                                                </div>
                                               

                                            

                                            <div class="row mb-3">
                                                <label class="fw-bolder">Imagen:</label>
                                                <div>
                                                    @if ($producto->img_path != null)
                                                        <img src="{{ Storage::url('public/productos/'.$producto->img_path) }}" alt="{{ $producto->nombre }}" class="img-fluid img-thumbnail border border-4 rounded">
                                                    @else
                                                        No tiene
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    
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

    <script>

    </script>
@endpush