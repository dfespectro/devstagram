<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        //comprobar si se comunica correctamente.. network fetch
        // $input = $request->all();
        // return response()->json($input);
        $imagen = $request->file('file');

        //Str::uuid() crea una id unica.... nose pueden tener en el servidor dos elementos con misma id
        $nombreImagen = Str::uuid() . "." . $imagen->extension();
        //guardar la imagen en el servidor usando las clases de intervention image
        $imagenServidor = Image::make($imagen);
        //fit es de la clase intervention y recorta la imagen en ese a mil por mil
        $imagenServidor->fit(1000, 1000);
        //ruta donde guardamos la imagen... crea una carpeta llamada uploads sino existe en la carpeta public
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen ]);
    }
}
