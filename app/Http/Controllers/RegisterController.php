<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd('$request');

        //modificar el request(ultima opcion)
        $request->request->add(['username' => Str::slug($request->username)]); //username sera la url por ello no debe tener caracteres extraños para usamos slug

        //validacion
        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20', //users es el nombre de la tabla en register.balde.php
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,  //dara error porque por defecto no espera este campo, agragalo en user.php para decirle que es seguro
            'email' => $request->email,
            'password' => Hash::make($request->password)  //la funcion hash encripta la contraseña
        ]);


        //Autenticas usuario     //auth completa la informacion del usuario para autenticarlo
        // auth()->attempt([                      //attempt para intentar autenticar el usuario
        //     'email' => $request->email,
        //     'password' => $request->pasword
        // ]);

        //otra forma de autenticar
        auth()->attempt($request->only('email', 'password'));

        //redirect
        return redirect()->route('posts.index', auth()->user());
    }
}
