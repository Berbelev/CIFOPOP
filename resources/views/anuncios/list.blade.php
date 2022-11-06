@extends('layouts.master')

@section('titulo', 'Listado de anuncios')

@section('contenido')
    <!-- parte SUPERIOR de la zona CENTRAL-->
    <!-------------------------------------------------------------------->
    <div class="row">
        <!-- PAGINACIÓN-->
        <div class="col-6 text-start">{{$anuncios->links()}}</div>


        @auth
            <!-- BOTON nueva anuncio-->
            <div class="col-6 text-end">
                <p>Nuevo anuncio <a href="{{route('anuncios.create')}}"
                    class="btn btn-success ml-2">+</a></p>
            </div>
        @endauth

    </div>
    <!------------------------------------------------------------------->


    <!-- FORMULARIO para la BUSQUEDA de anuncios search() -->
    <form method="GET" action="{{route('anuncios.search')}}" class="col-6 row">

        <input name="titulo" placeholder="Titulo" type="text" maxlength="16"
                class="col form-control mr-2 mb-2"
                value="{{ $titulo ?? ''}}">

        <input name="descripcion" placeholder="Descripcion" type="text" maxlength="16"
                class="col form-control mr-2 mb-2"
                value="{{ $descripcion ?? ''}}">

        <button type="submit" class="col btn btn-primary mr-2 mb-2" >
            Buscar</button>

        <a  href="{{route('anuncios.index')}}">
            <button type="button" class="col btn btn-primary mb-2">
                Quitar filtro
            </button>
        </a>
    </form>
    <!--------------------------------------------------------------------->

    <!-- listado de anuncios en la zona CENTRAL-->
    <table class="table table-striped table-bordered">
    @forelse($anuncios as $anuncio)

        @if ($loop->first)
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Titulo</th>
                <th>Precio</th>
                <th>Poblacion</th>
                <th>Propietario</th>
                <th>Fecha</th>
                <th>Operaciones</th>
            </tr>
        @endif

            <tr>
                <td>{{$anuncio->id}}</td>
                <td class="text-center" style="max-width: 80px" >

                    <img class="rounded" style="max-width: 80%"
                         alt="Imagen de {{$anuncio->titulo}} {{$anuncio->created_at}}"
                         title="Imagen de {{$anuncio->titulo}} {{$anuncio->created_at}}"
                         src="{{
                            $anuncio->imagen?
                            asset('storage/'.config('filesystems.anunciosImageDir')).'/'.$anuncio->imagen:
                            asset('storage/'.config('filesystems.anunciosImageDir')).'/'.'/default.jpg'
                         }}">
                </td>
                <td>{{$anuncio->titulo}}</td>
                <td style="text-align: center">{{$anuncio->importe}}</td>
                <td>{{$anuncio->user->poblacion}}</td>
                <td style="text-align:center ">{{$anuncio->user? $anuncio->user->name : 'Sin propietario'}}</td>
                <td>{{$anuncio->created_at}}</td>

                <td class="text-center">
                    <a href="{{route('anuncios.show',$anuncio->id)}}">
                        <img height="20" width="20" alt="Ver detalles" title="Ver detalles"
                             src="{{asset('imagenes/icons/show.png')}}">
                    </a>

                    @auth
                        @if(Auth::user()->can('update',$anuncio))
                            <a href="{{route('anuncios.edit',$anuncio->id)}}">
                                <img height="20" width="20" alt="Modificar" title="Modificar"
                                    src="{{asset('imagenes/icons/update.png')}}">
                            </a>
                        @endif

                        @if(Auth::user()->can('delete', $anuncio))
                            <a href="{{route('anuncios.delete',$anuncio->id)}}">
                                <img height="20" width="20" alt="Borrar" title="Borrar"
                                    src="{{asset('imagenes/icons/delete.png')}}">
                            </a>
                        @endif
                    @endauth
                </td>
            </tr>

        @if ($loop->last)
            <tr>
                <td colspan="7">Mostrando {{sizeof($anuncios)}} de {{$anuncios->total()}}.</td>
            <tr>
        @endif
    @empty
        <tr>
            <td colspan="3">No hay anuncios para mostrar</td>
        </tr>
    @endforelse
    </table>
    <!---------------------------------------------------------------------->
@endsection

