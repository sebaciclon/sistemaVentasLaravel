@extends('template')

@section('title', 'Editar Proveedor')

@push('css')
    <style>
        #descripcion {
            resize: none;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Editar Proveedor</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('proveedores.index') }}">Proveedores</a></li>
            <li class="breadcrumb-item active">Editar Proveedor</li>
        </ol>

        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('proveedores.update', ['proveedore' => $proveedore]) }}" method="POST"> 
                @csrf
                @method('PATCH')
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="nombre" class="form-label">Nombre</label> 
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre', $proveedore->persona->nombre)}}">
                        @error('nombre')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('nombre', $proveedore->persona->direccion)}}">
                        @error('direccion')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input name="telefono" id="telefono" class="form-control" value="{{old('nombre', $proveedore->persona->telefono)}}">
                        @error('telefono')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="reset" class="btn btn-secondary">Cancelar cambios</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
    
@push('js')
@endpush