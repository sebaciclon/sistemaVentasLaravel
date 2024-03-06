<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

Route::get('/panel', [HomeController::class, 'index'])->name('panel');

Route::get('/', [LoginController::class, 'index'])->name('login');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

// RUTA DE USUARIO
Route::controller(ProductoController::class)->middleware('auth')->group(function(){
    Route::get('productos/seleccionarCategoria','elegirCategoria')->name('seleccionarCategoria');

    Route::get('productos/porCategoria','porCategoria')->name('porCategoria');
    Route::get('productos/actualizarPreciosPorCategoria','actualizarCategoria')
        ->name('actualizarPreciosPorCategoria');

    Route::get('productos/porMarca','porMarca')->name('porMarca');
    Route::get('productos/actualizarPreciosPorMarca','actualizarMarca')
        ->name('actualizarPreciosPorMarca');
    
});

Route::resources([
    'categorias' => CategoriaController::class,
    'productos' => ProductoController::class,
    'personas' => PersonaController::class,
    'proveedores' => ProveedorController::class,
    'compras' => CompraController::class,
    'ventas' => VentaController::class,
    'usuarios' => UserController::class,
    'roles' => RoleController::class,
    'profile' => ProfileController::class,
    
]);

Route::get('/401', function() {
    return view('pages.401');
});

Route::get('/404', function() {
    return view('pages.404');
});

Route::get('/500', function() {
    return view('pages.500');
});



