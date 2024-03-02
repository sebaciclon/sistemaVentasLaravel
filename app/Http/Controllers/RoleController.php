<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeRolRequest;
use App\Http\Requests\updateRolRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    function __construct() 
    {
        $this->middleware('permission:ver-role|crear-role|editar-role|eliminar-role', ['only' => ['index']]);
        $this->middleware('permission:crear-role', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-role', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $roles = Role::all();
        return view('role.index', ['roles' => $roles]);
    }

    
    public function create()
    {
        $permisos = Permission::all();
        return view('role.create', ['permisos' => $permisos]);
    }

    
    public function store(storeRolRequest $request)
    {
        //dd($request);

        try {
            DB::beginTransaction();
            $rol = new Role();
            $rol->name = $request->name;
            $rol->save();

            //$rol = Role::create(['name' => $request->name]);
            //dd($request->permission->name);
            $rol->syncPermissions($request->permission);
            
            DB::commit();
        }catch (Exception $e) {
            //dd($e);
            DB::rollBack();
        }

        return redirect()->route('roles.index')->with('success', 'Rol registrado exitosamente');
    }
    
    public function edit(Role $role)
    {
        $permisos = Permission::all();
        return view('role.edit', ['role' => $role, 'permisos' => $permisos]);
    }

    
    public function update(updateRolRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();

            // actualizar rol
            Role::where('id', $role->id)
            ->update(['name' => $request->name]);

            // actualizar permisos
            $role->syncPermissions($request->permission);


            DB::commit();
        }catch (Exception $e){
            //dd($e);
            DB::rollBack();
        }

        return redirect()->route('roles.index')->with('success', 'Rol editado exitosamente');
    }

    
    public function destroy(string $id)
    {
        Role::where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente');
    }
}
