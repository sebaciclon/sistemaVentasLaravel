@extends('template')

@section('title', 'Ver venta')

@push('css')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Ver venta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></li>
            <li class="breadcrumb-item active">Ver venta</li>
        </ol>
    </div>

        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <!-- USUARIO-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        <input disabled type="text" class="form-control" value="Vendedor: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$venta->user->name}}">
                </div>
            </div>
            <!-- TIPO COMPROBANTE-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                        <input disabled type="text" class="form-control" value="Tipo de comprobante: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$venta->comprobante ? $venta->comprobante->tipo_comprobante : ''}}">
                </div>
            </div>
            <!-- N° COMPROBANTE-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                        <input disabled type="text" class="form-control" value="N° comprobante: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$venta->nro_comprobante}}">
                </div>
            </div>
            <!-- CLIENTE-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-person"></i></span>
                        <input disabled type="text" class="form-control" value="Cliente: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$venta->cliente ? $venta->cliente->persona->nombre : ''}}">
                </div>
            </div>
                <!-- FECHA-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                        <input disabled type="text" class="form-control" value="Fecha: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{ \Carbon\Carbon::parse($venta->fecha_hora)->format('d-m-Y') }}">
                </div>
            </div>

            <!-- TABLA -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table -me-1"></i>
                    Detalle de la venta
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-white">Producto</th>
                                <th class="text-white">Cantidad</th>
                                <th class="text-white">Precio venta</th>
                                <th class="text-white">Descuento</th>
                                <th class="text-white">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($venta->productos as $item)
                                <tr>
                                    <th>{{ $item->nombre }}</th>
                                    <th>{{ $item->pivot->cantidad}}</th>
                                    <th>{{ $item->pivot->precio_venta}}</th>
                                    <th>{{ $item->pivot->descuento}}</th>
                                    
                                    <th class="td-subtotal">
                                        {{ ($item->pivot->cantidad) * ($item->pivot->precio_venta) - ($item->pivot->descuento) }}
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6"></th>
                            </tr>
                            <tr>
                                <th>Total: </th>
                                <th id="th-total"></th>
                            </tr>
                        </tfoot>
                    </table>
                    <form action="{{ route('ventas.index') }}" method="GET">
                        <button type="submit" class="btn btn-success">Volver</button>
                    </form>
                </div>
            </div>
        </div>
    
@endsection
    
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

    <script>
        let filasSubtotal = document.getElementsByClassName('td-subtotal');
        let cont = 0;

        $(document).ready(function() {
            calcularValores();
        })

        function calcularValores() {
            for(let i = 0; i < filasSubtotal.length; i ++) {
                cont += parseFloat(filasSubtotal[i].innerHTML);
            }
            $('#th-total').html(cont);
        }
    </script>
@endpush