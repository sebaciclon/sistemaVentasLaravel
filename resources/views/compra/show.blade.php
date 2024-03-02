@extends('template')

@section('title', 'Ver compra')

@push('css')
    <style>
        #descripcion {
            resize: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Ver compra</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
            <li class="breadcrumb-item active">Ver compra</li>
        </ol>
    </div>

        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <!-- TIPO COMPROBANTE-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                        <input disabled type="text" class="form-control" value="Tipo de comprobante: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$compra->comprobante->tipo_comprobante}}">
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
                    <input disabled type="text" class="form-control" value="{{$compra->nro_comprobante}}">
                </div>
            </div>
            <!-- PROVEEDOR-->
            <div class="row mb-2">
                <div class="col-sm-4">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-person-walking-arrow-right"></i></span>
                        <input disabled type="text" class="form-control" value="Proveedor: ">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input disabled type="text" class="form-control" value="{{$compra->proveedor->persona->nombre}}">
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
                    <input disabled type="text" class="form-control" value="{{ \Carbon\Carbon::parse($compra->fecha_hora)->format('d-m-Y') }}">
                </div>
            </div>

            <!-- TABLA -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table -me-1"></i>
                    Detalle de la compra
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-white">Producto</th>
                                <th class="text-white">Cantidad</th>
                                <th class="text-white">Precio compra</th>
                                <th class="text-white">Porcentaje ganancia</th>
                                <th class="text-white">Precio venta</th>
                                <th class="text-white">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($compra->productos as $item)
                                <tr>
                                    <th>{{ $item->nombre }}</th>
                                    <th>{{ $item->pivot->cantidad}}</th>
                                    <th>{{ $item->pivot->precio_compra}}</th>
                                    <th>{{ $item->pivot->porcentaje_ganancia}}</th>
                                    <th>{{ $item->pivot->precio_venta}}</th>
                                    <th class="td-subtotal">{{ $item->pivot->cantidad * $item->pivot->precio_compra}}</th>
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
                    <form action="{{ route('compras.index') }}" method="GET">
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