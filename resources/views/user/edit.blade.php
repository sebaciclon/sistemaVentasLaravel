@extends('template')

@section('title', 'editar usuario')

@push('css')
    
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">editar usuario</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">editar usuario</li>
        </ol>

        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
            <form action="{{ route('usuarios.update', ['usuario' => $usuario]) }}" method="POST"> 
                @csrf
                @method('PATCH')
                <div class="row g-3">
                    <div class="row mb-4 mt-4">
                        <label for="name" class="col-sm-2 col-form-label">Nombre del usuario</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $usuario->name)}}">
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
                            <input type="email" name="email" id="name" class="form-control" value="{{ old('email', $usuario->email)}}">
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
                            <input type="password" name="password" id="password" class="form-control" >
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
                                
                                @foreach ($roles as $item)
                                    @if (in_array($item->name, $usuario->roles->pluck('name')->toArray()))
                                        <option selected value="{{ $item->name}}" @selected(old('role') == $item->name)>{{ $item->name }}</option>
                                    @else
                                        <option value="{{ $item->name}}" @selected(old('role') == $item->name)>{{ $item->name }}</option>
                                    @endif
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
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
    
@push('js')
@endpush