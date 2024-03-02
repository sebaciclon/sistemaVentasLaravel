<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Exception;

class PersonaController extends Controller
{

    function __construct() 
    {
        $this->middleware('permission:ver-persona|crear-persona|editar-persona|eliminar-persona', ['only' => ['index']]);
        $this->middleware('permission:crear-persona', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-persona', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-persona', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $personas = Cliente::with('persona')->get();
        
        return view('persona.index', ['personas' => $personas]);
    }

    
    public function create()
    {
        return view('persona.create');
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
            $persona->cliente()->create([
                'persona_id' => $persona->id
            ]);
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('personas.index')->with('success', 'Cliente ingresado exitosamente');
    }
    
    public function edit(Persona $persona)
    {
        //$cliente->load('persona');
        return view('persona.edit', ['persona' => $persona]);
    }

    
    public function update(UpdatePersonaRequest $request, Persona $persona)
    {
        try {
            DB::beginTransaction();
            $persona->nombre = $request->nombre;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->save();
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('personas.index')->with('success', 'Cliente actualizado exitosamente');
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
        $message = 'Cliente eliminado!';
        } else {
            Persona::where('id', $persona->id)
            ->update([
                'estado' => 1
        ]);
        $message = 'Cliente restaurado!';
        }
        

        return redirect()->route('personas.index')->with('success', $message);
    }
}
