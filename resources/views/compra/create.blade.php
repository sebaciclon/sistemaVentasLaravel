@extends('template')

@section('title', 'Crear compra')

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
        <h1 class="mt-4 text-center">Crear compra</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.create') }}">Crear producto</a></li>
            <li class="breadcrumb-item active">Crear compra</li>
        </ol>
    </div>
    
    <form action="{{ route('compras.store')}}" method="POST">
        @csrf
        <div class="container mt-4">
            <div class="row gy-4">
                <!-- COMPRA PRODUCTO -->
                <div class="col-md-8">
                    <div class="text-white bg-primary p-1 text-center">
                        Detalles de la compra
                    </div>
                    <div class="p-3 border border-3 border-primary">
                        <div class="row">
                            <!-- PRODUCTO -->
                            <div class="col-md-12 mb-2">
                                <div class="col-md-12 mb-2">
                                    <label class="form-label" for="producto_id">Producto <span class="text-muted">(obligatorio)</span></label>
                                    <select title="Seleccione un producto" data-size="5" data-live-search="true" name="producto_id" id="producto_id" class="form-control selectpicker show-tick">
                                        @foreach($productos as $tipo)
                                            <option value="{{$tipo->id}}" {{ old('producto_id') == $tipo->id ? 'selected' : '' }}>{{$tipo->nombre}}</option>
                                        @endforeach
                                    </select>
                                    @error('producto_id')
                                        <small class="text-danger">{{ '*'. $message }}</small>
                                    @enderror
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
                            <!-- PRECIO COMPRA -->
                            <div class="col-md-4">
                                <label for="precio_compra" class="form-label">Precio compra <span class="text-muted">(obligatorio)</span></label>
                                <input type="number" step="0.1" name="precio_compra" id="precio_compra" class="form-control" value="{{old('precio_compra')}}">
                                @error('precio_compra')
                                    <small class="text-danger">{{ '*'. $message }}</small>
                                @enderror
                            </div>
                            <!-- PORCENTAJE -->
                            <div class="col-md-4">
                                <label for="porcentaje_ganancia" class="form-label">Porcentaje ganancia <span class="text-muted">(obligatorio)</span></label>
                                <input type="text" name="porcentaje_ganancia" id="porcentaje_ganancia" class="form-control" value="{{old('porcentaje_ganancia')}}">
                                @error('porcentaje_ganancia')
                                    <small class="text-danger">{{ '*'. $message }}</small>
                                @enderror
                            </div>
                           
                            
                            <!-- BOTON AGREGAR -->
                            <div class="mt-2 mb-2 col-md-12  text-end">
                                <button id="btn_agregar" class="btn btn-primary" type="button">Agregar</button>
                            </div>
                            <!-- TABLE DETALLE DE LA COMPRA -->
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="tabla_detalle" class="table table-hover">
                                        <thead class="text-white bg-primary">
                                            <tr>
                                                <th class="text-white">#</th>
                                                <th class="text-white">Producto</th>
                                                <th class="text-white">Cantidad</th>
                                                <th class="text-white">Precio compra</th>
                                                <th class="text-white">Porcentaje de ganancia</th>
                                                <th class="text-white">Precio venta</th>
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
                                <button id="cancelar" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Cancelar compra</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PRODUCTO -->
                <div class="col-md-4">
                    <div class="text-white bg-success p-1 text-center">
                        Datos generales
                    </div>
                    <div class="p-3 border border-3 border-success">
                        <div class="row">
                            <!-- PROVEEDOR-->
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="proveedor_id">Proveedor <span class="text-muted">(obligatorio)</span></label>
                                <select title="Seleccione un proveedor" data-live-search="true" name="proveedor_id" id="proveedor_id" class="form-control selectpicker show-tick" data-size="2">
                                    @foreach($proveedores as $tipo)
                                        <option value="{{$tipo->id}}" {{ old('proveedor_id') == $tipo->id ? 'selected' : '' }}>{{$tipo->persona->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('proveedor_id')
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
                                <input type="text" name="nro_comprobante" id="nro_comprobante" class="form-control" value="">
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

                            <!-- BOTONES-->
                            <div class="col-md-12 mt-2 text-center">
                                <button type="submit" class="btn btn-success" id="guardar">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal para cancelar la compra-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmación</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Seguro quieres cancelar la compra?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button id="btnCancelarCompra" type="button" class="btn btn-danger" data-bs-dismiss="modal">Confirmar</button>
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
            $('#btn_agregar').click(function() {
                agregarProducto();
            });
        
            $('#btnCancelarCompra').click(function() {
                cancelarCompra();
            });

            disableButtons();
        });

        // VARIABLES
        let cont = 0;
        let subtotal = [];
        let sumas = 0;
        let igv = 0;
        let total = 0;

        function cancelarCompra() {
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

            //   reiniciar valores de las variables
            cont = 0;
            subtotal = [];
            sumas = 0;
            igv = 0;
            total = 0;

            $('#total').html(total);
            $('#inputTotal').val(total);
            limpiarCampos();
            disableButtons();
        }

        function disableButtons() {
            if(total == 0) {
                $('#guardar').hide();
                $('#cancelar').hide();
            } else {
                $('#guardar').show();
                $('#cancelar').show();
            }
        }

        function agregarProducto() {
            // OBTENER VALORES DE LOS CAMPOS
            let idProducto = $('#producto_id').val();
            let nameProducto = $('#producto_id option:selected').text();
            let cantidad = $('#cantidad').val();
            let precioCompra = $('#precio_compra').val();
            let precioVenta = $('#precio_venta').val();
            let porcentajeGanancia = $('#porcentaje_ganancia').val();

            
            // VALIDAR QUE LOS CAMPOS NO ESTEN VACIOS
            if(nameProducto != '' && cantidad != '' && precioCompra != '' && porcentajeGanancia != '') {

                if(parseFloat(cantidad) > 0 && parseFloat(precioCompra) > 0 && parseFloat(porcentajeGanancia) > 0) {
                    // CALCULAR PRECIO DE VENTA
                    let porcentaje = ((precioCompra * porcentajeGanancia) / 100);
                    let precioVenta1 = Number(precioCompra)  + Number(porcentaje) ;
                    // CALCULAR VALORES
                    subtotal[cont] = round(cantidad * precioCompra);
                    sumas += subtotal[cont];
                    total = round(sumas);
                    // CREAR LA FILA
                    let fila = '<tr id="fila' + cont + '">' +
                        '<th>'+ (cont + 1) +'</th>' +
                        '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">'+ nameProducto +'</td>' +
                        '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">'+ cantidad +'</td>' +
                        '<td><input type="hidden" name="arraypreciocompra[]" value="' + precioCompra + '">'+ '$ ' + precioCompra +'</td>' +
                        '<td><input type="hidden" name="arrayporcentaje[]" value="' + porcentajeGanancia + '">'+ porcentajeGanancia + ' %'+'</td>' +
                        '<td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta1 + '">'+ '$ ' + round(precioVenta1) +'</td>' +
                        '<td>'+ '$ ' + subtotal[cont] +'</td>' +
                        '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto('+ cont +')"><i class="fa-solid fa-trash"></i></button></td>' +
                        '</tr>';

                    $('#tabla_detalle').append(fila);
                    limpiarCampos();
                    cont ++;
                    disableButtons();

                    $('#total').html(total);
                    $('#inputTotal').val(total);
                } else {
                    showModal('Algún valor ingresado es incorrecto');
                }
                
            } else {
                showModal('Producto, Cantidad, Precio de compra y Porcentaje ganancia son obligatorios');
                
            }
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
                    $('#precio_compra').val('');
                    $('#precio_venta').val('');
                    $('#porcentaje_ganancia').val('');
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