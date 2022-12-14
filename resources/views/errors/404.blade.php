@extends('layouts.master')

@section('titulo', 'Error 404')

@section('contenido')
        <div class="m-10">
            <div class="content" style="text-align: center">
                <div class='title mt-5' style="font-size: 3rem">
                    ERROR 404: Uh-Oh.... :)
                    <figure>
                        <img class="rounded" width="400px"
                             alt="Error 404"
                             title="página no encontrada, error 404"
                             src="{{asset('imagenes/errores/404.jpeg')}}">
                    </figure>
                    <p>Pagina no encontrada.</p>
                </div>
                <div class="title mb-5" style="font-size: 2rem">
                    {{ $exception->getMessage()}}
                </div>
            </div>
        </div>
@endsection

@section('enlaces')
    @parent
    <a href="{{route('anuncios.index')}}" class="btn btn-primary m-2">Catálogo</a>
@endsection
