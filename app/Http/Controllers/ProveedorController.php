<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Exception;

class ProveedorController extends Controller
{

    function __construct() 
    {
        $this->middleware('permission:ver-proveedor|crear-proveedor|editar-proveedor|eliminar-proveedor', ['only' => ['index']]);
        $this->middleware('permission:crear-proveedor', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-proveedor', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-proveedor', ['only' => ['destroy']]);
    }

    public function index()
    {
        $proveedores = Proveedor::with('persona')->get();
        //dd($proveedores);
        return view('proveedor.index', ['proveedores' => $proveedores]);
    }

    
    public function create()
    {
        return view('proveedor.create');
    }

   
    public function store(StorePersonaRequest $request)
    {
        try {
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            
            $persona->save();
            $persona->proveedor()->create([
                'persona_id' => $persona->id
            ]);
            
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('proveedores.index')->with('success', 'Proveedor ingresado exitosamente');
    }

    
    
    public function edit(Proveedor $proveedore)
    {
        $proveedore->load('persona');
        //dd($proveedore);
        return view('proveedor.edit', ['proveedore' => $proveedore]);
    }

    
    public function update(UpdatePersonaRequest $request, Proveedor $proveedore)
    {
        
        try {
            DB::beginTransaction();
            Persona::where('id', $proveedore->id + 1)->update($request->validated());
            
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente');
    }

    
    public function destroy($id)
    {
        $message = '';
        $persona = Persona::find($id);
        if($persona->estado == 1) {
            Persona::where('id', $persona->id)
            ->update([
                'estado' => 0
        ]);
        $message = 'Proveedor eliminado!';
        } else {
            Persona::where('id', $persona->id)
            ->update([
                'estado' => 1
        ]);
        $message = 'Proveedor restaurado!';
        }
        

        return redirect()->route('proveedores.index')->with('success', $message);
    }
}
