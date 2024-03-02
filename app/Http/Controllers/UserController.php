<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeUsuarioRequest;
use App\Http\Requests\updateUsuarioRequest;
use App\Models\User;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    function __construct() 
    {
        $this->middleware('permission:ver-user|crear-user|editar-user|eliminar-user', ['only' => ['index']]);
        $this->middleware('permission:crear-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-user', ['only' => ['destroy']]);
    }
    
    
    public function index()
    {
        $users = User::all();
        return view('user.index', ['users' => $users]);
    }

    
    public function create()
    {
        $roles = Role::all();
        return view('user.create', ['roles' => $roles]);
    }

    
    public function store(storeUsuarioRequest $request)
    {
        //dd($request);

        try {
            DB::beginTransaction();

            $fieldHash = Hash::make($request->password);
            $request->merge(['password' => $fieldHash]);

            $user = User::create($request->all());

            $user->assignRole($request->role);
            
            //dd($request);
            DB::commit();
        }catch (Exception $e) {
            //dd($e);
            DB::rollBack();
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario registrado exitosamente');
    }

    
    
    public function edit(User $usuario)
    {
        //dd($user);
        $roles = Role::all();
        return view('user.edit', ['roles' => $roles, 'usuario' => $usuario]);
    }

    
    public function update(updateUsuarioRequest $request, User $usuario)
    {
        try {
            DB::beginTransaction();

            if (empty($request->password)) {
                $request = Arr::except($request, array('password'));
            } else {
                $fieldHash = Hash::make($request->password);
                $request->merge(['password' => $fieldHash]);
            }

            $usuario->update($request->all());

            $usuario->syncRoles($request->role);
            
            //dd($request);
            DB::commit();
        }catch (Exception $e) {
            //dd($e);
            DB::rollBack();
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario editado exitosamente');
    }

    
    public function destroy(string $id)
    {
        $user = User::find($id);
        $rolUser = $user->getRoleNames()->first();

        $user->removeRole($rolUser);
        $user->delete();
        
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente');
    }
}
