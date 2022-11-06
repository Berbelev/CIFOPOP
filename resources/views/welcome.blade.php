@extends('layouts.master')

@section('titulo', 'Welcome')

@section('contenido')
    <figure>
        <img class="row mt-2 mb-2 col-10 offset-1"
            style="max-width: 400px"
             alt="Moto de portada"
             src="{{asset('imagenes/anuncios/portada.png')}}">
    </figure>
@endsection

@section('enlaces')
@endsection
