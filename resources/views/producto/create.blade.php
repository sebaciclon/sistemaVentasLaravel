@extends('template')

@section('title', 'Crear producto')

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
        <h1 class="mt-4 text-center">Crear Producto</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Crear producto</li>
        </ol>

        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data"> 
                @csrf
                <div class="row g-3">
                    <!-- SELECT CATEGORIAS -->
                    <div class="col-md-4">
                        <label class="form-label" for="categoria_id">Categoría <span class="text-muted">(obligatorio)</span></label>
                        <select title="Seleccione una categoría" data-size="5" data-live-search="true" name="categoria_id" id="categoria_id" class="form-control selectpicker show-tick">
                            @foreach($categorias as $tipo)
                                <option value="{{$tipo->id}}" {{ old('categoria_id') == $tipo->id ? 'selected' : '' }}>{{$tipo->nombre}}</option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>
                    <!-- NOMBRE -->
                    <div class="col-md-4">
                        <label for="nombre" class="form-label">Nombre <span class="text-muted">(obligatorio)</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                        @error('nombre')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>
                    <!-- MARCA -->
                    <div class="col-md-4">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" name="marca" id="marca" class="form-control" value="{{old('marca')}}">
                        @error('marca')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>
                    <!-- DESCRIPCION -->
                    <div class="col-md-8">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea rows="2" name="descripcion" id="descripcion" class="form-control">{{old('descripcion')}}</textarea>
                        @error('descripcion')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>
                    
                    <!-- CODIGO -->
                    <div class="col-md-4">
                        <label for="codigo" class="form-label">Codigo</label>
                        <input type="text" name="codigo" id="codigo" class="form-control" value="{{old('codigo')}}">
                        @error('codigo')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>
                    <!-- FECHA VENCIMIENTO -->
                    <div class="col-md-4">
                        <label for="fecha_vencimiento" class="form-label">Fecha de vencimiento</label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{old('fecha_vencimiento')}}">
                        @error('fecha_vencimiento')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>
                    <!-- IMAGEN -->
                    <div class="col-md-4">
                        <label for="img_path" class="form-label">Imagen</label>
                        <input type="file" name="img_path" id="img_path" class="form-control" accept="Image/*" value="{{old('img_path')}}">
                        @error('img_path')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>
                    <!-- BOTON GUARDAR -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
    
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush