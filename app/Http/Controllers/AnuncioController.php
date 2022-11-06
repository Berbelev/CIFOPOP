<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;


class AnuncioController extends Controller{

    /*==========================================================
    |   LISTA DE MOTOS
    |   1. index()
    |===========================================================
     */
    /** _________________________________________________________
     *
     * index()
     * ---------------------------------------------------------
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        /**
        *| Recupera los anuncios de la BDD usando el modelo
        *| Ordenado por id descendente y
        *| Paginación de 10 resultados por pagina
        */
        $anuncios= Anuncio::orderBy('id','DESC')
            ->paginate(config('pagination.anuncios', 10));



        /**
         *| Carga la vista para el listado
         *| la vista se llamará list.blade.php y se encontrará en la carpeta anuncios
         *| a las vistas hay que pasarles los datos a modo de array asociativo
         */
    return View::make('anuncios.list',['anuncios'=>$anuncios]);
    }
}
