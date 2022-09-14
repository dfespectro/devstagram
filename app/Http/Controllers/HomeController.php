<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //tiene que estar autencticado para entrar
    }
    public function __invoke()
    {
        //pluck toma solo los valores especificados
        $ids = auth()->user()->followings->pluck('id')->toArray(); //tomamos las ids de los que seguimos
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20); //tomamos los post de los que seguimos

        return view('home', [
            'posts' => $posts   //le pasamos los post a la vista
        ]);
    }
}
