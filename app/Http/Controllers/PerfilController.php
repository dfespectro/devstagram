<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        //solo un usuario autenticado puede entrar
        $this->middleware('auth');
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        //modificar el request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            //'unique:users,username,'.auth()->user()->id --- revisa si el username es unico pero permite el que tiene actualmente
            'username' => ['required', 'unique:users,username,'.auth()->user()->id, 'min:3', 'max:20', 'not_in:editar-perfil'] //not_In es una lista negra, in es una lista obligatoria
        ]);

        if($request->imagen)
        {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            $imagenPath = public_path('perfiles') . "/" . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null; // ?? = or
        $usuario->save();

        //redireccionar
        return redirect()->route('posts.index', $usuario->username); //usamos $usuario y no auth() porque es mas actulizado
    
    }
}
