<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeVentaRequest;
use App\Http\Requests\updateVentaRequest;
use App\Models\Cliente;
use App\Models\Comprobante;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class VentaController extends Controller
{

    function __construct() 
    {
        $this->middleware('permission:ver-venta|crear-venta|mostrar-venta|eliminar-venta', ['only' => ['index']]);
        $this->middleware('permission:crear-venta', ['only' => ['create', 'store']]);
        $this->middleware('permission:mostrar-venta', ['only' => ['show']]);
        $this->middleware('permission:eliminar-venta', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $ventas = Venta::with('comprobante', 'cliente.persona', 'user')
        ->where('estado', 1)
        ->latest()
        ->get();
        //dd($compras);
        return view('venta.index', ['ventas' => $ventas]);
    }

    
    public function create()
    {
        $comprobantes = Comprobante::orderBy('tipo_comprobante', 'asc')
        ->where('estado', 1)
        ->get();
        //$proveedores = Proveedor::all();
        $clientes = Cliente::whereHas('persona', function($query) {
            $query->where('estado', 1);
        })->get();
        $productos = Producto::orderBy('nombre', 'asc')
        ->where('estado', 1)
        ->get();
        //return $productos;
        return view('venta.create', ['comprobantes' => $comprobantes, 
                                        'clientes' => $clientes,
                                        'productos' => $productos]);
    }

    
    public function store(storeVentaRequest $request)
    {
        //dd($request->validated());
        
        try {
            DB::beginTransaction();
            // LLENAR LA TABLA VENTAS
            
            $venta = new Venta();
            $venta->fecha_hora = $request->fecha_hora1;
            $venta->nro_comprobante = $request->nro_comprobante;
            $venta->total = $request->total;
            $venta->comprobante_id = $request->comprobante_id;
            $venta->cliente_id = $request->cliente_id;
            $venta->user_id = $request->user_id;
            $venta->save();
            
            // LLENAR LA TABLA VENTA PRODUCTOS
            //1. RECUPERAR LOS ARREGLOS
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
            $arrayDescuento = $request->get('arraydescuento');

            // 2. REALIZAR EL LLENADO
            $cont = 0;
            $sizeArray = count($arrayProducto_id);
            
            while($cont < $sizeArray) {
                $venta->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont],
                        'descuento' => $arrayDescuento[$cont]
                    ]
                ]);
                //dd($venta->productos());
                // 3. ACTUALIZAR EL STOCK Y AGREGAR PRECIO VENTAS
                $producto = Producto::find($arrayProducto_id[$cont]);
                
                $stockActual = $producto->stock;
                $stockNuevo = floatval($arrayCantidad[$cont]);
                DB::table('productos')->where('id', $producto->id)
                ->update(['stock' => $stockActual - $stockNuevo]);

                $cont ++;
            }

            DB::commit();
        }catch(Exception $e) {
            //dd($e);
            DB::rollBack();
        }
        //return redirect()->to('/');
        return redirect()->route('ventas.index')->with('success', 'Venta ingresada exitosamente');
    }

    
    public function show(Venta $venta)
    {
        //dd($venta->productos);
        return view('venta.show', ['venta' => $venta]);
    }

    
    public function edit(string $id)
    {
        //
    }

    
    public function update(updateVentaRequest $request, string $id)
    {
        //
    }

    
    public function destroy(string $id)
    {
        //
    }
}
