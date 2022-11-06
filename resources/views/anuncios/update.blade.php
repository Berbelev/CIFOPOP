@extends('layouts.master')

@section('titulo', 'Actualizar Anuncio')

@section('contenido')
    <!-- Formulario de edición - falseo a valor PUT-->
    <form class="my-2 border p-5" method="POST" enctype="multipart/form-data"
            action="{{
                URL::temporarySignedRoute('anuncios.update', now()->addMinutes(1),$anuncio->id)
                }}">

        {{csrf_field()}}
        <!-- por PUT-->
        <input name="_method" type="hidden" value="PUT">

        <!-- Titulo-->
        <div class="form-group row">
            <label for="inputTitulo" class="col-sm-2 col-form-label">Titulo</label>
            <input name="titulo" value="{{$anuncio->titulo}}" type="text"
            class="up form-control col-sm-10" id="inputTitulo"
            placeholder="Titulo" maxlength="255" required >
        </div>

        <!-- Descripcion-->
        <div class="form-group row">
            <label for="inputDescripcion" class="col-sm-2 col-form-label">Descripcion</label>
            <input name="descripcion" value="{{$anuncio->descripcion}}" type="text"
            class="up form-control col-sm-10" id="inputDescripcion"
            placeholder="Descripcion" maxlength="255" required >
        </div>

        <!-- Precio-->
        <div class="form-group row">
            <label for="inputPrecio" class="col-sm-2 col-form-label">Precio</label>
            <input name="importe" value="{{$anuncio->importe}}" type="number"
            class="up form-control col-sm-4" id="inputPrecio"
            min="0" step="0.01" required >
        </div>



        <!--Actualización para la imagen - subida de archivos-->
        <div class="form-group row my-3">
            <div class="col-sm-9">
                <!--Opciones para subir archivo-->
                    <!--Si hay imagen->Sustituir Imagen -->
                    <!--Si NO hay imagen->Añadir Imagen -->
                <label for="inputImagen" class="col-sm-2 col-form-label">
                    {{$anuncio->imagen?'Sustituir': 'Añadir'}} imagen
                </label>
                <input name="imagen" type="file" class="form-control-file"
                    id="inputImagen">

                @if ($anuncio->imagen)
                    <!-- Checkbox Eliminar Imagen-->
                    <div class="form-check my-3">
                        <label class="form-check-label" for="inputEliminar">
                            <input type="checkbox" class="form-check-input" name="eliminarimagen"
                                    id="inputEliminar" value="checkedValue" >
                        Eliminar imagen
                        </label>
                    </div>
                    <script>
                        // si se titulo el checkbox eliminarimagen
                        inputEliminar.onchange =function(){
                            // desabilita el imput Sustituir Imagen
                            inputImagen.disabled=this.checked;
                        }
                    </script>
                @endif
            </div>

            <div class="col-sm-3">
                <label>Imagen actual :</label>
                <img class="rounded img-thumbnail my-3"
                    alt="Imagen de {{$anuncio->titulo}} {{$anuncio->descripcion}}"
                    title="Imagen de {{$anuncio->titulo}} {{$anuncio->descripcion}}"
                    src="{{
                            $anuncio->imagen?
                            asset('storage/'.config('filesystems.anunciosImageDir')).'/'.$anuncio->imagen:
                            asset('storage/'.config('filesystems.anunciosImageDir')).'/'.'/default.jpg'
                        }}">
            </div>
        </div>

        <div class="form-group row">
            <button type="submit" class="btn btn-success m-2 mt-5">Guardar</button>
            <button type="reset" class="btn btn-secondary m-2">Restablecer</button>
        </div>
    </form>

    <div class="text-end my-3">
        <div class="btn-group mx-2">
            <a class="mx-2" href="{{route('anuncios.show',$anuncio->id)}}">
            <img height="40" width="40" src="{{asset('imagenes/icons/show.png')}}"
            alt="Detalles" title="Detalles"></a>

            <a class="mx-2" href="{{route('anuncios.delete',$anuncio->id)}}">
            <img height="40" width="40" src="{{asset('imagenes/icons/delete.png')}}"
            alt="Borrar" title="Borrar"></a>
        </div>
    </div>
@endsection

@section('enlaces')
    @parent
    <a href="{{route('anuncios.index')}}" class="btn btn-primary m-2">Garaje</a>
@endsection
