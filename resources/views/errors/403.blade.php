@extends('layouts.master')

@section('titulo', 'Error 403')

@section('contenido')
        <div class="m-10">
            <div class="content" style="text-align: center">
                <div class='title mt-5' style="font-size: 3rem">
                    ERROR 403:
                    <figure>
                        <img class="rounded" width="400px"
                             alt="Error 403"
                             title="prohibido, error 403"
                             src="{{asset('imagenes/errores/403.jpg')}}">
                    </figure>
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
