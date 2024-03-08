@extends('template')

@section('title', ' Productos actualizar precios')

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
        <h1 class="mt-4 text-center">Productos para actualizar precios por categoria</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Productos para actualizar precios por categoria</li>
        </ol>
        <form action="{{ route('actualizarPreciosPorCategoria') }}" method="GET" enctype="multipart/form-data"> 
            @csrf
            
            <input type="hidden" name="categoria_id" id="categoria_id" value="{{$productos[0]->categoria_id}}">
            <div class="col-md-4">
                <label for="" class="form-label mb-4">Ingrese el porcentaje de actualización <span class="text-muted">(obligatorio)</span></label>
                <input type="text" name="porcentaje" id="porcentaje" class="form-control mb-4" value="{{old('porcentaje')}}">
                <div class="mb-2">
                    @error('porcentaje')
                        <small class="text-danger">{{ '*'. $message }}</small>
                    @enderror
                </div>
            </div>
            

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
                                <th>Precio</th>
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
                                    
                                    <td>{{$producto->precio_venta}}</td>
                                </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- BOTON GUARDAR -->
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                
            </div>
        </form>
    </div>
@endsection
    
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
    
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

   
@endpush