@extends('layouts.master')

@section('titulo', 'Nuevo Anuncio ')

@section('contenido')
    <form class="my-2 border p-5" method="POST" enctype="multipart/form-data"
          action="{{route('anuncios.store')}}">

        {{csrf_field()}}

        <div class="form-group row">
            <label for="inputTitulo" class="col-sm-2 col-form-label">
            Titulo</label>
            <input name="titulo" type="text" class="up form-control col-sm-10"
                   id="inputTitulo" placeholder="Titulo" maxlenght="255" required
                   value="{{old('titulo')}}">
        </div>

        <div class="form-group row">
            <label for="inputDescripcion" class="col-sm-2 col-form-label">
            Descripcion</label>
            <input name="descripcion" type="text" class="up form-control col-sm-10"
                   id="inputDescripcion" placeholder="Descripcion" maxlenght="255" required
                   value="{{old('descripcion')}}">
        </div>


        <div class="form-group row">
            <label for="inputImporte" class="col-sm-2 col-form-label">
            Importe</label>
            <input name="importe" type="number" class="up form-control col-sm-4"
                   id="inputImporte"  maxlenght="11" min="0" step="0.1" required
                   value="{{old('importe')}}">
        </div>



        <!--Actualización para la imagen - subida de archivos-->
        <div class="form-group row">
            <label for="inputImagen" class="col-sm-2 col-form-label">Imagen</label>
            <input name="imagen" type="file" class="form-control-file col-sm-10"
                   id="inputImagen">
        </div>

        <div class="form-group row">
            <button type="submit" class="btn btn-success m-2 mt-5">Guardar</button>
            <button type="reset" class="btn btn-secondary m-2">Borrar</button>
        </div>
    </form>
@endsection

@section('enlaces')
    @parent
    <a href="{{route('anuncios.index')}}" class="btn btn-primary m-2">Garaje</a>
@endsection

