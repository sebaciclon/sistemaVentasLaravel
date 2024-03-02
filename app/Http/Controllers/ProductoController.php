<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeProductoRequest;
use App\Http\Requests\updateProductoRequest;
use App\Models\Categoria;
use App\Models\Compra_producto;
use App\Models\Producto;
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
