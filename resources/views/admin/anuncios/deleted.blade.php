@extends('layouts.master')



@section('contenido')

<div class="container">
    <h3 class="mt-4">Anuncios Borrados</h3>
    <div class="text-start">
        {{$anuncios->links()}}
    </div>
        <!--------------------------------------------------------------------->
        <!--LISTADO DE MIS ANUNCIOS BORRADAS-->
        <!--------------------------------------------------------------------->
        <table class="table table-striped table-bordered">
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Titulo</th>
                <th>Poblacion</th>
                <th>Importe</th>
                <th>Propietario</th>
                <th></th>
                <th></th>
            </tr>

            @forelse ($anuncios as $anuncio)
            <tr>
                <td><b>{{$anuncio->id}}</b></td>
                <td class="text-center" style="max-width: 80px" >

                    <img class="rounded" style="max-width: 80%"
                        alt="Imagen de {{$anuncio->titulo}}"
                        title="Imagen de {{$anuncio->titulo}}"
                        src="{{
                            $anuncio->imagen?
                            asset('storage/'.config('filesystems.anunciosImageDir')).'/'.$anuncio->imagen:
                            asset('storage/'.config('filesystems.anunciosImageDir')).'/'.'/default.jpg'
                        }}">
                </td>

                <td>{{$anuncio->titulo}}</td>
                <td>{{$anuncio->user->poblacion}}</td>
                <td>{{$anuncio->importe}}</td>
                <td>{{$anuncio->user ? $anuncio->user->name : 'Desconocido'}}</td>

                <td class="text-center">
                    <a href="{{route('anuncios.restore',$anuncio->id)}}">
                        <button class="btn btn-success">Restaurar</button>
                    </a>
                </td>
                <td class="text-center">
                    <a onclick='
                        if(confirm("¿Estás seguro de borrar el anuncio definitivamente?"))
                            this.nextElementSibling.submit();'>
                        <button class="btn btn-danger">Eliminar</button>
                    </a>
                    <form method="POST" action="{{ route('anuncios.purge')}}">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <input name="anuncio_id" type="hidden" value="{{$anuncio->id}}">
                    </form>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="8" class="alert alert-danger">No hay anuncios borrados.</td>
                </tr>
            @endforelse
        </table>
    </div>
                <!---------------------------------------------------------------------->
@endsection
