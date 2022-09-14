<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user) //el user esta almacenando la info de quien queremos seguir
    {   //como tiene tablas pivote usamos attach para muchos a muchos ademas estamos fuera de las conveciones de laravel
        $user->followers()->attach(auth()->user()->id);

        return back();
    }

    public function destroy(User $user) 
    {
        $user->followers()->detach(auth()->user()->id);

        return back();
    }
}
