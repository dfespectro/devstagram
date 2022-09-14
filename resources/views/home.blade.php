@extends('layouts.app')

@section('titulo')
    Pagina principal
@endsection

@section('contenido')
    <x-listar-post :posts="$posts"/>  {{--añadiendo componente...se puede usar como slots, pasamos la varible al contructor del componente ya que esta definicion es una llamada a la clase del componente --}}
@endsection