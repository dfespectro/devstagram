<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post)
    {
        //validacion
        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);

        //almacenamiento
        Comentario::create([
            //la user id enviada por web.php es la del usuario quien creo la publicacio, no nos sirve
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]); //recordar poner el fillable en el model

        //Mensaje
        return back()->with('mensaje', 'Comentario realizado');
    }
}
