@extends('template')

@section('title', 'Ventas')

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
        <h1 class="mt-4 text-center">Ventas</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Ventas</li>
        </ol>

        <a href="{{ route('ventas.create')}}"><button type="button" class="btn btn-primary mb-4">Realizar venta</button></a>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-sack-dollar"></i>
                Ventas
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha y hora</th>
                            <th>Vendedor</th>
                            <th>Tipo Comprobante</th>
                            <th>N° Comprobante</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $item)
                            <tr>
                                <td>
                                    {{
                                        \Carbon\Carbon::parse($item->fecha_hora)->format('d-m-Y').', '.
                                        \Carbon\Carbon::parse($item->fecha_hora)->format('H:i')
                                    }}
                                </td>
                                <td>{{ $item->user->name}}</td>
                                @if ($item->comprobante_id != null)
                                    <td>{{ $item->comprobante->tipo_comprobante}}</td>
                                @else
                                    <td></td>
                                @endif
                                
                                <td>{{ $item->nro_comprobante}}</td>
                                @if ($item->cliente_id != null)
                                    <td>{{ $item->cliente->persona->nombre}}</td>
                                @else
                                    <td></td>
                                @endif
                                
                                <td>$ {{ $item->total}}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <form action="{{ route('ventas.show', ['venta' => $item]) }}" method="GET">
                                            <button type="submit" class="btn btn-success">Ver</button>
                                        </form>
                                        
                                        <!--<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $item->id }}">Eliminar</button>-->
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de confirmación</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Seguro quieres eliminar la compra?
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{ route('compras.destroy', ['compra' => $item->id]) }}" method="POST">
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