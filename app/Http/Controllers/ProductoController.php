<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeActualizacionPreciosRequest;
use App\Http\Requests\storeProductoRequest;
use App\Http\Requests\updateProductoRequest;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{

    function __construct() 
    {
        $this->middleware('permission:ver-producto|crear-producto|editar-producto|eliminar-producto', ['only' => ['index']]);
        $this->middleware('permission:crear-producto', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-producto', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-producto', ['only' => ['destroy']]);
    }

    // ELEGIR CATEGORIA, MARCA O PROVEEDOR
    public function elegirCategoria() 
    {
        $categorias = Categoria::all();
        $productos = Producto::all()->where('estado', 1);
        
        $proveedores = Proveedor::whereHas('persona', function($query) {
            $query->where('estado', 1);
        })->get();
        
        return view('producto.elegirCategoria', ['categorias' => $categorias, 'productos' => $productos,
                                                'proveedores' => $proveedores]);
    }

    // MUESTRA LOS PRODUCTOS DE UNA DETERMINADA CATEGORIA
    public function porCategoria(Request $request) 
    {
        $productos = Producto::where('categoria_id', $request->categoria_id)->get();
        $id = $request->categoria_id;
        return view('producto.indexCategoria', ['productos' => $productos, 'id' => $id]);
    }

    // ACTUALIZA LOS PRECIOS DE LOS PRODUCTOS DE UNA DETERMINADA CATEGORIA
    public function actualizarCategoria(storeActualizacionPreciosRequest $request) 
    {
        //dd($request);
        $sizeArray = 0;
        //$productos = Producto::all()->where('categoria_id', $request->categoria_id);
        $productos = Producto::where('categoria_id', $request->categoria_id)->get();
        //dd($productos);
        $cont = 0;
        $sizeArray = count($productos);
        
        while($cont < $sizeArray) {
            $porcentaje = $request->porcentaje * $productos[$cont]->precio_venta /100;
            $precio_final = $porcentaje + $productos[$cont]->precio_venta;
            $productos[$cont]->precio_venta = $precio_final;

            DB::table('productos')->where('id', $productos[$cont]->id)
            ->update(['precio_venta' => $precio_final]);
                
            DB::table('compra_producto')->where('producto_id', $productos[$cont]->id)
            ->update(['precio_venta' => $productos[$cont]->precio_venta]);
            $cont++;
        }
        return redirect()->route('seleccionarCategoria')->with('success', 'Actualización de producto exitosa!');
    }

    // MUESTRA LOS PRODUCTOS DE UNA DETERMINADA MARCA
    public function porMarca(Request $request) 
    {
        $productos = Producto::where('marca', $request->marca)->get();
        
        return view('producto.indexMarca', ['productos' => $productos]);
    }

    // ACTUALIZA LOS PRECIOS DE LOS PRODUCTOS DE UNA DETERMINADA MARCA
    public function actualizarMarca(storeActualizacionPreciosRequest $request) 
    {
        //dd($request);
        $productos1 = Producto::where('marca', $request->marca)->get();
        $cont = 0;
        $sizeArray = count($productos1);
        while($cont < $sizeArray) {
            
            $porcentaje = $request->porcentaje * $productos1[$cont]->precio_venta /100;
            $precio_final = $porcentaje + $productos1[$cont]->precio_venta;
            $productos1[$cont]->precio_venta = $precio_final;

            DB::table('productos')->where('id', $productos1[$cont]->id)
            ->update(['precio_venta' => $precio_final]);

            DB::table('compra_producto')->where('producto_id', $productos1[$cont]->id)
            ->update(['precio_venta' => $productos1[$cont]->precio_venta]);
                
            $cont++;
        }
        return redirect()->route('seleccionarCategoria')->with('success', 'Actualización de producto exitosa!');
    }

    // MUESTRA LOS PRODUCTOS DE UN DETERMINADO NOMBRE
    public function porNombre(Request $request) 
    {
        $productos = Producto::where('nombre', $request->nombre)->get();
        
        return view('producto.indexNombre', ['productos' => $productos]);
    }

    // ACTUALIZA LOS PRECIOS DE LOS PRODUCTOS DE UN DETERMINADO NOMBRE
    public function actualizarNombre(storeActualizacionPreciosRequest $request) 
    {
        //dd($request);
        $productos1 = Producto::where('nombre', $request->nombre)->get();
        //dd($productos1);
        $cont = 0;
        $sizeArray = count($productos1);
        //dd($sizeArray);
        while($cont < $sizeArray) {
            
            $porcentaje = $request->porcentaje * $productos1[$cont]->precio_venta /100;
            $precio_final = $porcentaje + $productos1[$cont]->precio_venta;
            $productos1[$cont]->precio_venta = $precio_final;
            DB::table('productos')->where('id', $productos1[$cont]->id)
            ->update(['precio_venta' => $precio_final]);

            DB::table('compra_producto')->where('producto_id', $productos1[$cont]->id)
            ->update(['precio_venta' => $productos1[$cont]->precio_venta]);

            
            $cont++;
        }
        return redirect()->route('seleccionarCategoria')->with('success', 'Actualización de producto exitosa!');
    }


    
    
    public function index()
    {
        
        $productos = Producto::all();
        $categorias = Categoria::all();
        
        return view('producto.index', ['productos' => $productos, 'categorias' => $categorias]);
    }

    
    public function create()
    {
        //$categorias = Categoria::all();
        $categorias = Categoria::orderBy('nombre', 'asc')
        ->where('estado', 1)
        ->get();
        
        return view('producto.create', ['categorias' => $categorias]);
    }

    
    public function store(storeProductoRequest $request)
    {
        //dd($request);
        try {
            DB::beginTransaction();
            $producto = new Producto();
            if($request->hasFile('img_path')) {
                $name = $producto->hanbleUploadImage($request->file('img_path'));
            } else {
                $name = null;
            }
            $producto->nombre = $request->nombre;
            $producto->codigo = $request->codigo;
            $producto->descripcion = $request->descripcion;
            $producto->marca = $request->marca;
            $producto->fecha_vencimiento = $request->fecha_vencimiento;
            $producto->img_path = $name;
            //$producto->stock = $request->stock;
            $producto->categoria_id = $request->categoria_id;
            $producto->save();
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('productos.index')->with('success', 'Producto ingresado exitosamente');
    }

    
    
    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre', 'asc')
        ->where('estado', 1)
        ->get();
        return view('producto.edit', ['producto' => $producto, 'categorias' => $categorias]);
    }

    
    public function update(updateProductoRequest $request, Producto $producto)
    {
        try {
            DB::beginTransaction();
            //$producto = new Producto();
            if($request->hasFile('img_path')) {
                $name = $producto->hanbleUploadImage($request->file('img_path'));
                // eliminar si existe una imagen en este producto
                if(Storage::disk('public')->exists('productos/'.$producto->img_path)) {
                    Storage::disk('public')->delete('productos/'.$producto->img_path); 
                }
            } else {
                $name = $producto->img_path;
            }
            $producto->nombre = $request->nombre;
            $producto->codigo = $request->codigo;
            $producto->descripcion = $request->descripcion;
            $producto->marca = $request->marca;
            $producto->fecha_vencimiento = $request->fecha_vencimiento;
            $producto->img_path = $name;
            //$producto->stock = $request->stock;
            $producto->categoria_id = $request->categoria_id;
            $producto->save();
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

       
    public function destroy($id)
    {
        $message = '';
        $producto = Producto::find($id);
        if($producto->estado == 1) {
            Producto::where('id', $producto->id)
            ->update([
                'estado' => 0
        ]);
        $message = 'Producto eliminado!';
        } else {
            Producto::where('id', $producto->id)
            ->update([
                'estado' => 1
        ]);
        $message = 'Producto restaurado!';
        }
        

        return redirect()->route('productos.index')->with('success', $message);
    }
}
