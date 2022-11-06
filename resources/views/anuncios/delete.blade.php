@extends('layouts.master')

@section('titulo', "Borrado del anuncio $anuncio->titulo $anuncio->created_at")

@section('contenido')
    <!-- Formulario de confirmación de eliminación - falseo a valor DELETE-->
    <form class="my-2 border p-5" method="POST"
          action="{{URL::signedRoute('anuncios.destroy', $anuncio->id)}}">

        {{csrf_field()}}
        <input name="_method" type="hidden" value="DELETE">

        <figure>
            <figcaption>Imagen actual: </figcaption>
            <img class="rounded" style="max-width: 400px"
                 alt="Imagen de {{$anuncio->titulo}} {{$anuncio->created_at}}"
                 src="{{$anuncio->imagen?
                 asset('storage/'.config('filesystems.anunciosImageDir')).'/'.$anuncio->imagen:
                 asset('storage/'.config('filesystems.anunciosImageDir')).'/'.'/default.jpg'
                 }}">
        </figure>

        <label for="confirmdelete">Confirmar el borrado de {{"$anuncio->titulo $anuncio->created_at"}}</label>
        <input type="submit" class="btn btn-danger m-4" alt="Borrar" title="Borrar"
            value="Borrar" id="confirmdelete">
    </form>
<!-- FIN DE LA SECCIÓN "contenido"-->
@endsection

@section('enlaces')
    <!-- Amplia la sección de enlaces con lista de anuncios-->
    @parent
        <a href="{{route('anuncios.index')}}" class="btn btn-primary m-2">Garaje</a>
        <a href="{{route('anuncios.show',$anuncio->id)}}" class="btn btn-primary m-2">
            Regresar a detalles de la anuncio</a>
    <!-- FIN SECCIÓN "enlaces"-->
@endsection
