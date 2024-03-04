@extends('template')

@section('title', 'Elegir categoria')

@push('css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
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
    <h1 class="mt-4 text-center">Elegir categoria para actualizar precios</h1>

    <div class="container card mt-6">
        <form class="card-body" action="{{ route('porCategoria')}}" method="GET">
            @csrf
            @method('PATCH')
    
            <div class="row mt-4">
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled type="text" class="form-control" value="Elegir categoria">
                    </div>
                    
                </div>
                <!-- SELECT CATEGORIAS -->
                <div class="col-md-6">
                        <select title="Seleccione una categoría" data-size="5" data-live-search="true" name="categoria_id" id="categoria_id" class="form-control selectpicker show-tick">
                            @foreach($categorias as $tipo)
                                <option value="{{$tipo->id}}" {{ old('categoria_id') == $tipo->id ? 'selected' : '' }}>{{$tipo->nombre}}</option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <small class="text-danger">{{ '*'. $message }}</small>
                        @enderror
                    </div>                
                <div class="col-sm-6">
                    @error('name')
                        <small class="text-danger">{{ '*'. $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col text-center mt-4">
                <input class="btn btn-success" type="submit" value="Seleccionar">
            </div>
        </form>
    </div>
    
</div>
@endsection
    
@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush