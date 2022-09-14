<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);  //si intenta entra sin logearse esto se ejecuta y lo manda a login asi protege la ruta
    }

    //resive la variable user enviada por web.php
    public function index(User $user)
    {
        //obtenemos la informacion de la base de datos donde user_id sea igual a user->id
        $posts = Post::where('user_id', $user->id)->latest()->paginate(5);
        //enviamos la var user a la vista
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        //$request es la informacion del registro dentro del cual encontramos a user
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        //para que funcione hay que poner estas variable en fllable en ek model
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id,
        // ]);

        //otra forma de hacer esto
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        

        //forma convecional de laravel
        //               post() es el metodo de relacion creado en el modelo de user
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => $request->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
        // llamamos la funcion delete en el policy relacionado con post
        $this->authorize('delete', $post); 
        $post->delete();

        //eliminar imagen del post
        $imagen_path = public_path('uploads/' . $post->imagen);
        if (File::exists($imagen_path))
        {
            unlink($imagen_path); //unlink es de php
        }
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
