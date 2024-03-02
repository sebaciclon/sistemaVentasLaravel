@extends('template')

@section('title', 'Crear usuario')

@push('css')
    
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Crear usuario</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">Crear usuario</li>
        </ol>

        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('usuarios.store') }}" method="POST"> 
                @csrf
                <div class="row g-3">
                    <div class="row mb-4 mt-4">
                        <label for="name" class="col-sm-2 col-form-label">Nombre del usuario</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name')}}">
                        </div>
                        <div class="col-sm-6">
                            @error('name')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                        </div>
                    </div>

                    <div class="row mb-4 mt-4">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" id="name" class="form-control" value="{{ old('email')}}">
                        </div>
                        <div class="col-sm-6">
                            @error('email')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                        </div>
                    </div>

                    <div class="row mb-4 mt-4">
                        <label for="password" class="col-sm-2 col-form-label">Contraseña</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            @error('password')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                        </div>
                    </div>

                    <div class="row mb-4 mt-4">
                        <label for="password_confirm" class="col-sm-2 col-form-label">Repetir contraseña</label>
                        <div class="col-sm-10">
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            @error('password_confirm')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                        </div>
                    </div>

                    <div class="row mb-4 mt-4">
                        <label for="role" class="col-sm-2 col-form-label">Seleccione un rol</label>
                        <div class="col-sm-10">
                            <select name="role" id="role" class="form-select">
                                <option value="" selected disabled>Seleccione</option>
                                @foreach ($roles as $item)
                                    <option value="{{ $item->name}}" @selected(old('role') == $item->name)>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            @error('role')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                        </div>
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