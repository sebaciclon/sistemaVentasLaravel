<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeCategoriaRequest;
use App\Http\Requests\updateCategoriaRequest;
use App\Models\Categoria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{

    function __construct() 
    {
        $this->middleware('permission:ver-categoria|crear-categoria|editar-categoria|eliminar-categoria', ['only' => ['index']]);
        $this->middleware('permission:crear-categoria', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-categoria', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-categoria', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $categorias = Categoria::all();
        return view('categoria.index', ['categorias' => $categorias]);
    }

    
    public function create()
    {
        return view('categoria.create');
    }

    
    public function store(storeCategoriaRequest $request)
    {
        try {
            DB::beginTransaction();
            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->save();
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('categorias.index')->with('success', 'Categoría ingresada exitosamente');
    }

    public function edit(Categoria $categoria)
    {
        return view('categoria.edit', ['categoria' => $categoria]);
    }

    
    public function update(updateCategoriaRequest $request, Categoria $categoria)
    {
        //$contribuyente = contribuyente::find($request->contribuyente_id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;

        $categoria->save();

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada exitosamente');
    }

    
    public function destroy($id)
    {
        $message = '';
        $categoria = Categoria::find($id);
        if($categoria->estado == 1) {
            Categoria::where('id', $categoria->id)
            ->update([
                'estado' => 0
        ]);
        $message = 'Categoría eliminada!';
        } else {
            Categoria::where('id', $categoria->id)
            ->update([
                'estado' => 1
        ]);
        $message = 'Categoría restaurada!';
        }
        

        return redirect()->route('categorias.index')->with('success', $message);
    }
}
