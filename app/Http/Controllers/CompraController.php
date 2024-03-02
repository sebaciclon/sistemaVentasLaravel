<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeCompraRequest;
use App\Http\Requests\updateCompraRequest;
use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Exception;


class CompraController extends Controller
{

    function __construct() 
    {
        $this->middleware('permission:ver-compra|crear-compra|mostrar-compra|eliminar-compra', ['only' => ['index']]);
        $this->middleware('permission:crear-compra', ['only' => ['create', 'store']]);
        $this->middleware('permission:mostrar-compra', ['only' => ['show']]);
        $this->middleware('permission:eliminar-compra', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $compras = Compra::with('comprobante', 'proveedor.persona')
        ->where('estado', 1)
        ->latest()
        ->get();
        //dd($compras);
        return view('compra.index', ['compras' => $compras]);
    }

    
    public function create()
    {
        $comprobantes = Comprobante::orderBy('tipo_comprobante', 'asc')
        ->where('estado', 1)
        ->get();
        //$proveedores = Proveedor::all();
        $proveedores = Proveedor::whereHas('persona', function($query) {
            $query->where('estado', 1);
        })->get();
        $productos = Producto::orderBy('nombre', 'asc')
        ->where('estado', 1)
        ->get();
        
        return view('compra.create', ['comprobantes' => $comprobantes, 
                                        'proveedores' => $proveedores,
                                        'productos' => $productos]);
    }

    
    public function store(storeCompraRequest $request)
    {
        //dd($request->validated());
        try {
            DB::beginTransaction();
            // LLENAR LA TABLA COMPRAS
            
            $compra = new Compra();
            $compra->fecha_hora = $request->fecha_hora1;
            $compra->nro_comprobante = $request->nro_comprobante;
            $compra->total = $request->total;
            $compra->comprobante_id = $request->comprobante_id;
            $compra->proveedor_id = $request->proveedor_id;
            $compra->save();
            
            // LLENAR LA TABLA COMPRA PRODUCTOS
            //1. RECUPERAR LOS ARREGLOS
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arraypreciocompra');
            $arrayPorcentaje = $request->get('arrayporcentaje');
            $arrayPrecioVenta = $request->get('arrayprecioventa');

            // 2. REALIZAR EL LLENADO
            $cont = 0;
            $sizeArray = count($arrayProducto_id);
            
            while($cont < $sizeArray) {
                
                $compra->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_compra' => $arrayPrecioCompra[$cont],
                        'porcentaje_ganancia' => $arrayPorcentaje[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont]
                    ]
                ]);
                
                // 3. ACTUALIZAR EL STOCK Y AGREGAR PRECIO VENTAS
                $producto = Producto::find($arrayProducto_id[$cont]);
                $producto->precio_venta = $arrayPrecioVenta[$cont];
                $stockActual = $producto->stock;
                $stockNuevo = floatval($arrayCantidad[$cont]);
                DB::table('productos')->where('id', $producto->id)
                ->update(['stock' => $stockActual + $stockNuevo, 'precio_venta' => $arrayPrecioVenta[$cont]]);

                //$compraProducto->producto_id = $producto->id;
                //$compraProducto->save();

                $cont ++;
            }

            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('compras.index')->with('success', 'Compra ingresada exitosamente');
    }

    
    public function show(Compra $compra)
    {
        //dd($compra->productos);
        return view('compra.show', ['compra' => $compra]);
        
    }

    
    public function edit(string $id)
    {
        //
    }

    
    public function update(updateCompraRequest $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}
