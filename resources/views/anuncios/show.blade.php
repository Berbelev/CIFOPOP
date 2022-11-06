@extends('layouts.master')

@section('titulo', "Detalles del anuncio $anuncio->titulo $anuncio->created_at")

@section('contenido')
    <table class="table table-striped table-bordered">

        <tr>
            <th scope="row">ID</th>
            <td>{{$anuncio->id}}</td>
        </tr>
        <tr>
            <th scope="row">Titulo</th>
            <td>{{$anuncio->titulo}}</td>
        </tr>
        <tr>
            <th scope="row">Descripcion </th>
            <td>{{$anuncio->descripcion}}</td>
        </tr>
        <tr>
            <th scope="row">Precio</th>
            <td>{{$anuncio->importe}}</td>
        </tr>
        <tr>
            <th scope="row">Proietario </th>
            <td>{{$anuncio->user? $anuncio->user->name : 'Sin propietario'}}</td>
        </tr>
        <tr>
            <th scope="row">Poblacion</th>
            <td>{{$anuncio->user->poblacion}}</td>
        </tr>



        <tr>
            <th scope="row">Fecha </th>
            <td>{{$anuncio->created_at}}</td>
        </tr>


        @if ($anuncio->updated_at)
        <tr>
            <th scope="row">Modificado </th>
            <td>{{$anuncio->created_at}}</td>
        </tr>
        @endif

        <tr>
            <th scope="row">Imagen: </th>
            <td class="text-start">
                <img class="rounded" style="max-width: 400px"
                         alt="Imagen de {{$anuncio->titulo}} {{$anuncio->created_at}}"
                         title="Imagen de {{$anuncio->titulo}} {{$anuncio->created_at}}"
                         src="{{
                            $anuncio->imagen?
                            asset('storage/'.config('filesystems.anunciosImageDir')).'/'.$anuncio->imagen:
                            asset('storage/'.config('filesystems.anunciosImageDir')).'/'.'/default.jpg'
                         }}">
            </td>
        </tr>

    </table>
    <div class="text-end my-3">
        <div class="btn-group mx-2">
            @can('update', $anuncio)
                 <a class="mx-2" href="{{route('anuncios.edit',$anuncio->id)}}">
                <img height="40" width="40" src="{{asset('imagenes/icons/update.png')}}"
                alt="Modificar" title="Modifiar"></a>
            @endcan

            @can('delete', $anuncio)
                <a class="mx-2" href="{{route('anuncios.delete',$anuncio->id)}}">
                <img height="40" width="40" src="{{asset('imagenes/icons/delete.png')}}"
                alt="Borrar" title="Borrar"></a>
            @endcan
        </div>
    </div>
@endsection

@section('enlaces')
    @parent
    <a href="{{route('anuncios.index')}}" class="btn btn-primary m-2">Garaje</a>
@endsection
