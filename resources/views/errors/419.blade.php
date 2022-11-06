@extends('layouts.master')

@section('titulo', 'Error 419')

@section('contenido')
        <div class="m-10">
            <div class="content" style="text-align: center">
                <div class='title mt-5' style="font-size: 3rem">
                    ERROR 419:
                    <figure>
                        <img class="rounded" width="400px"
                             alt="Error 419"
                             title="prohibido, error 419"
                             src="{{asset('imagenes/errores/419.png')}}">
                    </figure>
                    <p>Lo siento, tu sesión ha expirado.</p>
                    <p>Por favor, refresca y prueba de nuevo.</p>
                </div>
                <div class="title mb-5" style="font-size: 2rem">
                    {{ $exception->getMessage()}}
                </div>
            </div>
        </div>
@endsection

@section('enlaces')
    @parent
    <a href="{{route('bikes.index')}}" class="btn btn-primary m-2">Garaje</a>
@endsection
