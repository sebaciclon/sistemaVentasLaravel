@extends('template')

@section('title', 'Crear Cliente')

@push('css')
    <style>
        #descripcion {
            resize: none;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear Cliente</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('personas.index') }}">Clientes</a></li>
            <li class="breadcrumb-item active">Crear Cliente</li>
        </ol>

        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('personas.store') }}" method="POST"> 
                @csrf
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                        @error('nombre')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion')}}">
                        @error('direccion')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input name="telefono" id="telefono" class="form-control">{{old('telefono')}}</input>
                        @error('telefono')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
    
@push('js')
@endpush