<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    
    public function index()
    {
        if(Auth::check()) {
            return redirect()->route('panel');
        }
        return view('auth.login');
    }

    public function login(storeLoginRequest $request)
    {
        // VALIDAR CREDENCIALES
        if(!Auth::validate($request->only('email', 'password'))) {
            return redirect()->to('login')->withErrors('Credenciales incorrectas');
        }

        //CREAR UN SESION
        $user = Auth::getProvider()->retrieveByCredentials($request->only('email', 'password'));
        Auth::login($user);
        return redirect()->route('panel');
    }

    

    
}
