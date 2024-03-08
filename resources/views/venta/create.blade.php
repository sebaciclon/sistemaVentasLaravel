@extends('template')

@section('title', 'Realizar venta')

@push('css')
    <style>
        #descripcion {
            resize: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Realizar venta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></li>
            <li class="breadcrumb-item active">Realizar venta</li>
        </ol>
    </div>

    <form action="{{ route('ventas.store')}}" method="POST">
        @csrf
        <div class="container mt-4">
            <div class="row gy-4">
                <!-- COMPRA PRODUCTO -->
                <div class="col-md-8">
                    <div class="text-white bg-primary p-1 text-center">
                        Detalles de la venta
                    </div>
                    <div class="p-3 border border-3 border-primary">
                        <div class="row">
                            <!-- PRODUCTO -->
                            <div class="col-md-12 mb-2">
                                <div class="col-md-12 mb-2">
                                    <label class="form-label" for="producto_id">Producto <span class="text-muted">(obligatorio)</span></label>
                                    <select title="Seleccione un producto" data-size="3" data-live-search="true" name="producto_id" id="producto_id" class="form-control selectpicker show-tick">
                                        @foreach($productos as $tipo)
                                            <option value="{{$tipo->id}}-{{$tipo->stock}}-{{$tipo->precio_venta}}">{{$tipo->nombre}}</option>
                                        @endforeach
                                    </select>
                                    @error('producto_id')
                                        <small class="text-danger">{{ '*'. $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <!-- STOCK -->
                            <div class="d-flex justify-content-end mb-4">
                                <div class="col-md-6 mb-2">
                                    <div class="row">
                                        <label for="stock" class="form-label col-sm-4">Stock</label>
                                        <div class="col-sm-8">
                                            <input disabled type="number" name="stock" id="stock" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- CANTIDAD -->
                            <div class="col-md-4">
                                <label for="cantidad" class="form-label">Cantidad <span class="text-muted">(obligatorio)</span></label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{old('cantidad')}}">
                                @error('cantidad')
                                    <small class="text-danger">{{ '*'. $message }}</small>
                                @enderror
                            </div>
                            <!-- PRECIO VENTA -->
                            <div class="col-md-4">
                                <label for="precio_venta" class="form-label">Precio venta </label>
                                <input disabled type="number" step="0.1" name="precio_venta" id="precio_venta" class="form-control" value="">
                                @error('precio_venta')
                                    <small class="text-danger">{{ '*'. $message }}</small>
                                @enderror
                            </div>
                            <!-- DESCUENTO -->
                            <div class="col-md-4">
                                <label for="descuento" class="form-label">Descuento </label>
                                <input type="number" step="0.1" name="descuento" id="descuento" class="form-control" value="{{old('descuento')}}">
                                @error('descuento')
                                    <small class="text-danger">{{ '*'. $message }}</small>
                                @enderror
                            </div>
                            
                            <!-- BOTON AGREGAR -->
                            <div class="mt-2 mb-2 col-md-12  text-end">
                                <button id="btn_agregar" class="btn btn-primary" type="button">Agregar</button>
                            </div>
                            <!-- TABLE DETALLE DE LA VENTA -->
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="tabla_detalle" class="table table-hover">
                                        <thead class="text-white bg-primary">
                                            <tr>
                                                <th class="text-white">#</th>
                                                <th class="text-white">Producto</th>
                                                <th class="text-white">Cantidad</th>
                                                <th class="text-white">Precio venta</th>
                                                <th class="text-white">Descuento</th>
                                                <th class="text-white">Subtotal</th>
                                                <th class="text-white"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Total: $</th>
                                                <th><input type="hidden" name="total" value="0" id="inputTotal"> <span id="total">0</span></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 mb-2 ">
                                <button id="cancelarVenta" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Cancelar venta</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- VENTA -->
                <div class="col-md-4">
                    <div class="text-white bg-success p-1 text-center">
                        Datos generales
                    </div>
                    <div class="p-3 border border-3 border-success">
                        <div class="row">
                            <!-- CLIENTE-->
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="cliente_id">Cliente <span class="text-muted">(obligatorio)</span></label>
                                <select title="Seleccione un cliente" data-live-search="true" name="cliente_id" id="cliente_id" class="form-control selectpicker show-tick" data-size="2">
                                    @foreach($clientes as $tipo)
                                        <option value="{{$tipo->id}}" {{ old('cliente_id') == $tipo->id ? 'selected' : '' }}>{{$tipo->persona->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('cliente_id')
                                    <small class="text-danger">{{ '*'. $message }}</small>
                                @enderror
                            </div>
                            <!-- TIPO COMPROBANTE-->
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="comprobante_id">tipo de comprobante <span class="text-muted">(obligatorio)</span></label>
                                <select title="Seleccione un comprobante" data-live-search="true" name="comprobante_id" id="comprobante_id" class="form-control selectpicker show-tick" data-size="2">
                                    @foreach($comprobantes as $tipo)
                                        <option value="{{$tipo->id}}" {{ old('comprobante_id') == $tipo->id ? 'selected' : '' }}>{{$tipo->tipo_comprobante}}</option>
                                    @endforeach
                                </select>
                                @error('comprobante_id')
                                    <small class="text-danger">{{ '*'. $message }}</small>
                                @enderror
                            </div>
                            
                            <!-- N° COMPROBANTE-->
                            <div class="col-md-12">
                                <label for="nro_comprobante" class="form-label">N° comprobante <span class="text-muted">(obligatorio)</span></label>
                                <input type="text" name="nro_comprobante" id="nro_comprobante" class="form-control" value="{{old('nro_comprobante')}}">
                                @error('nro_comprobante')
                                    <small class="text-danger">{{ '*'. $message }}</small>
                                @enderror
                            </div>

                            <!-- FECHA Y HORA-->
                            <div class="col-md-6 mt-2">
                                <label for="fecha_hora" class="form-label">Fecha <span class="text-muted">(obligatorio)</span></label>
                                <input readonly type="date" name="fecha_hora" id="fecha_hora" class="form-control border-success"  value="<?php echo date("Y-m-d")?>">
                                <?php 
                                use Carbon\Carbon;
                                $fechaHora = Carbon::now()->toDateTimeString();
                                ?>
                                <input type="hidden" name="fecha_hora1" value="{{ $fechaHora}}">
                                @error('fecha_hora')
                                    <small class="text-danger">{{ '*'. $message }}</small>
                                @enderror
                            </div>
                            <!-- USER -->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id}}">

                            <!-- BOTONES-->
                            <div class="col-md-12 mt-2 text-center">
                                <button type="submit" class="btn btn-success" id="guardar">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para cancelar la venta-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Seguro quieres cancelar la venta?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button id="btnCancelarVenta" type="button" class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>    
@endsection
    
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#producto_id').change(mostrarValores);
            
            $('#btn_agregar').click(function() {
                agregarProducto();
            });

            $('#btnCancelarVenta').click(function() {
                cancelarVenta();
            });

            disableButtons();
        });

        // VARIABLES
        let cont = 0;
        let subtotal = [];
        let sumas = 0;
        let total = 0;

        

        function cancelarVenta() {
            $('#tabla_detalle tbody').empty();

            let fila = '<tr>' +
                        '<th></th>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '<td></td>' +
                        '</tr>';
            $('#tabla_detalle').append(fila);        

            //   reiniciar valores de las variables
            cont = 0;
            subtotal = [];
            sumas = 0;
            total = 0;

            $('#total').html(total);
            $('#inputTotal').val(total);
            limpiarCampos();
            disableButtons();
        }

        // MOSTRAR VALORES DE PRECIO Y STOCK
        function mostrarValores() {
            let dataProducto = document.getElementById('producto_id').value.split('-');
            //console.log(dataProducto);
            $('#stock').val(dataProducto[1]);
            $('#precio_venta').val( dataProducto[2]);
        }

        

        function agregarProducto() {
            // OBTENER VALORES DE LOS CAMPOS
            let dataProducto = document.getElementById('producto_id').value.split('-');
            let idProducto = dataProducto[0];
            let nameProducto = $('#producto_id option:selected').text();
            let stock = $('#stock').val();
            let cantidad = $('#cantidad').val();
            let precioVenta = $('#precio_venta').val();
            let descuento = $('#descuento').val();

            if(descuento == '') {
                descuento = 0;
            }

            
            // VALIDAR QUE LOS CAMPOS NO ESTEN VACIOS
            if(idProducto != '' && cantidad != '') {

                if(parseFloat(cantidad) > 0 && parseFloat(stock) > 0 && parseFloat(descuento) >= 0) {

                    if(parseFloat(cantidad) <= parseFloat(stock)) {
                        // CALCULAR VALORES
                        subtotal[cont] = round(cantidad * precioVenta - descuento);
                        sumas += subtotal[cont];
                        total = round(sumas);

                        // CREAR LA FILA
                        let fila = '<tr id="fila' + cont + '">' +
                            '<th>'+ (cont + 1) +'</th>' +
                            '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">'+ nameProducto +'</td>' +
                            '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">'+ cantidad +'</td>' +
                            '<td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">'+ '$ ' + precioVenta +'</td>' +
                            '<td><input type="hidden" name="arraydescuento[]" value="' + descuento + '">'+ '$ ' + descuento +'</td>' +
                            '<td>'+ '$ ' + subtotal[cont] +'</td>' +
                            '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto('+ cont +')"><i class="fa-solid fa-trash"></i></button></td>' +
                            '</tr>';

                        // ACCIONES DESPUES DE AGREGAR LA FILA
                        $('#tabla_detalle').append(fila);
                        limpiarCampos();
                        cont ++;
                        disableButtons();

                        // MOSTRAR LOS CAMPOS CALCULADOS
                        $('#total').html(total);
                        $('#inputTotal').val(total);
                    } else {
                        showModal('La cantidad ingresada es mayor al stock');
                    }
                } else {
                    showModal('Algún valor ingresado es incorrecto');
                }
                
            } else {
                showModal('Los campos cantidad y producto son obligatorios');
                
            }
        }

        function disableButtons() {
            //console.log(total);
            if(total === 0) {
                $('#guardar').hide();
                $('#cancelarVenta').hide();
            } else {
                $('#guardar').show();
                $('#cancelarVenta').show();
            }
        }

        function round(num, decimales = 2) {
            var signo = (num >= 0 ? 1 : -1);
            num = num * signo;
            if(decimales === 0)
                return signo * Math.round(num);
            num = num.toString().split('e');
            num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
            num = num.toString().split('e');
            return signo * (+(num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales)));
        }

        function eliminarProducto(indice) {
            sumas -= round(subtotal[indice]);
            total = round(sumas);

            $('#total').html(total);
            $('#inputTotal').val(total);

            $('#fila'+indice).remove();
            disableButtons();
        }

        function limpiarCampos() {
            let select = $('#producto_id');
            select.selectpicker('val', '');
            $('#cantidad').val('');
            $('#stock').val('');
            $('#precio_venta').val('');
            $('#descuento').val('');
        }

        function showModal(message, icon = 'error') {
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
            icon: icon,
            title: message
            });
        }

        
    </script>
@endpush