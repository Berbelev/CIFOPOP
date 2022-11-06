@extends('layouts.master')
@section('titulo', 'Mis Anuncios')


@section('contenido')
@if(!Auth::user())
    <div class="alert alert-danger" role="alert">
        {{ __('Debes estár identificado para acceder tu espacio personal') }}
        <a class="stretched-link">{{route('login')}}</a>
    </div>
@endif

@if (session('resent'))
<div class="alert alert-success" role="alert">
    {{ __('Hemos enviado un nuevo link de verificación a tu correo electrónico.') }}
</div>
@endif

<!--Si el usuario no ha verificado su email-->
@if(empty(Auth::user()->email_verified_at))
    <!--Alertarle de que realice la operación-->
    <div class="alert alert-danger" role="alert">
        {{ __('Antes de continuar, por favor, confirme su correo electrónico con el enlace de verificación que le fue enviado. Si no ha recibido el correo electrónco') }}
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('haga clic aquí para solicitar otro.') }}</button>.
        </form>
    </div>
@endif


    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Mi Perfil') }}
                </div>
                    <div class="card-body">
                        @auth
                            @if(Auth::user())
                            {{__('Identificado correctamente')}}
                            <br>
                            <table class="table table-borderless">
                                <tr>
                                    <th >Usuario Identificado: </th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th scope="row">User:</th>
                                    <td>{{Auth::user()->username}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nombre:</th>
                                    <td>{{Auth::user()->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">e-mail:</th>
                                    <td>{{Auth::user()->email}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Población:</th>
                                    <td>{{Auth::user()->poblacion}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Teléfono:</th>
                                    <td>{{Auth::user()->telefono}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Verificación del e-mail:</th>
                                    <td>{{Auth::user()->email_verified_at? 'Verificado' : 'Pendiente'}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Fecha de creación:</th>
                                    <td>{{Auth::user()->created_at}}</td>
                                </tr>

                            </table>
                            @endif
                        @endauth
                    </div>
            </div>
        </div>
    </div>
    <br>
    <!--------------------------------------------------------------------->
    <!--LISTADO DE MIS ANUNCIOS-->
    <!--------------------------------------------------------------------->
    <table class="table table-striped table-bordered">
        @forelse($anuncios as $anuncio)

            @if ($loop->first)
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Titulo</th>
                    <th>Precio</th>
                    <th>Creado</th>
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


        <!--------------------------------------------------------------------->
        <!--LISTADO DE MIS ANUNCIOS BORRADOS-->
        <!--------------------------------------------------------------------->
        @if (count($deleteAnuncios))
            <h3 class="mt-4">Anuncios Borradas</h3>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Titulo</th>
                    <th>Precio</th>
                    <th>Creado</th>
                    <th></th>
                    <th></th>
                </tr>

                @foreach ($deleteAnuncios as $anuncio)
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
                    <td>{{$anuncio->created_at}}</td>

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
                @endforeach
            </table>
        @endif

                <!---------------------------------------------------------------------->
@endsection
