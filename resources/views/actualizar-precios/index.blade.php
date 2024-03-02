@extends('template')

@section('title', 'Perfil')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    
<div class="container">
    <h1 class="mt-4 text-center">Configurar perfíl</h1>

    <div class="container card mt-4">
        <form class="card-body" action="{{ route('profile.update', ['profile' => $user])}}" method="POST">
            @csrf
            @method('PATCH')
    
            <div class="row mt-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Nombres">
                    </div>
                    
                </div>
                <div class="col-sm-8">
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name)}}">
                </div>
                <div class="col-sm-4"></div>                  
                <div class="col-sm-6">
                    @error('name')
                        <small class="text-danger">{{ '*'. $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Email">
                    </div>
                </div>
                    
                <div class="col-sm-8">
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email)}}">
                </div>
                <div class="col-sm-4"></div>
                <div class="col-sm-8">
                    @error('email')
                        <small class="text-danger">{{ '*'. $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Contraseña">
                    </div>
                </div>
                    
                <div class="col-sm-8">
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>

            <div class="col text-center mt-4">
                <input class="btn btn-success" type="submit" value="Guardar cambios">
            </div>
        </form>
    </div>
    
</div>
@endsection
    
@push('js')
@endpush