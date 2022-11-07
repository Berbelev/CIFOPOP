<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;

use Illuminate\Http\Request;
use App\Http\Requests\AnuncioRequest;
use App\Http\Requests\AnuncioUpdateRequest;
use App\Http\Requests\AnuncioDeleteRequest;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

use Illuminate\Auth\Access\AuthorizationException;


class AnuncioController extends Controller {

    /* ===========================================================
    |   CONSTRUCTOR
     *///=========================================================
    /**
     * MIDDLEWARE EN CONTROLADORES:
     *
     *  Pone un middleware a todos los métodos del controlador:
     *
     */
    public function __construct(){

        /**
        *   Para las operaciones con anuncios
        *   el usuario debe estar verificado
        *   excepto para :index(), show() y search()
        */
        $this->middleware('verified')->except(['index','show','search']);

        /**
         * El método para eliminar una anuncio requiere de confirmación de la clave
         */
        $this->middleware('password.confirm')->only('destroy');

    }


    /*==========================================================
    |   LISTA DE ANUNCIOS
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


    /*
    |===========================================================
    |   GUARDAR ANUNCIO
    |   2.1_ create() y 2.2_ store()
    |===========================================================
     */
    /** _________________________________________________________
     *
     * 2.1_ create()
     * ---------------------------------------------------------
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        // Carga la vista con el formulario
        return view('anuncios.create');

    }

    /** _________________________________________________________
     *
     * 2.2_ store()
     * ---------------------------------------------------------
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\AnuncioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnuncioRequest $request){

        // _1_ RECUPERAR datos del formulario excepto la imagen
        $datos = $request->only(['titulo','descripcion', 'importe'
                                 ]);

        // _2_ NULL será el valor por defecto de la imagen
        $datos +=['imagen'=>NULL];

        // _3_ Recuperación de la imagen
        if($request->hasFile('imagen')){

            // _3.a_sube la imagen al directorio indicado en el fichero config
            $ruta=$request->file('imagen')->store(config('filesystems.anunciosImageDir'));
            ;
            // _3.b_asignar a la imagen el nombre del fichero para ser guadado en la BDD
            $datos['imagen']= pathinfo($ruta, PATHINFO_BASENAME);
        }

        // recupera el id del usuario identificado y lo gruada en user_id de la anuncio
        $datos['user_id']= $request->user()->id;

        // _4_ Creción y guardado del nuevo anuncio
        $anuncio = Anuncio::create($datos);

        // TODO:EVENTO
        // _5_ Despachar evento
        // Para la primera anuncio creada por un usuario.
        //if($request->user()->anuncios->count() == 1)
        //    FirstAnuncioCreated::dispatch($anuncio, $request->user());


        // _6_ redireccion a los detalles de la anuncio creada
        return redirect()
            ->route('anuncios.show', $anuncio->id)
            ->with('success', "Nuevo anuncio $anuncio->titulo , añadido correctamente.")
            ->cookie('lastInsertID', $anuncio->id,0);


    }
/*
    |===========================================================
    |   DETALLES DE LA anuncio
    |   3. show()
    |===========================================================
     */
    /** _________________________________________________________
     *
     * 3. show()
     * ---------------------------------------------------------
     * Display the specified resource.
     *
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Http\Response
     */
    public function show( Anuncio $anuncio) {


        //carga la vista correspondiente
        // y le pasa la anuncio
        return view('anuncios.show', ['anuncio'=>$anuncio]);
    }

    /*
    |===========================================================
    |   ACTUALIZACIÓN DEL ANUNCIO
    |   4.1_ edit() y 4.2_update()
    |===========================================================
     */
    /** _________________________________________________________
     *
     * 4.1_ edit()
     * ---------------------------------------------------------
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Anuncio $anuncio)    {

        // Autorización mediante policy
        if($request->user()->cant('delete',$anuncio))
            abort(401, 'No puedes actualizar esta anuncio');

        // carga la vista con el formulario para modificar la anuncio
        return view('anuncios.update', ['anuncio'=>$anuncio]);
    }

    /** _________________________________________________________
     *
     * 4.2_ update()
     * ---------------------------------------------------------
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\AnuncioUpdateRequest  $request
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Http\Response
     */
    public function update(anuncioUpdateRequest $request, Anuncio $anuncio)   {

        // comporbar la validez de la firma de la URL
        if(!$request->hasValidSignature())
            abort(401, 'La firma de la URL ha caducado :(');

        // toma los datos del formulario
        $datos =$request->only('titulo','descripcion', 'importe');


        // SI llega una nueva imágen...
        if($request->hasFile('imagen')){
            // ... SI IMAGEN,
            if($anuncio->imagen){
                // ... marcamos la imagen antigua para ser borrada ... si el update va bien...
                $aBorrar = config('filesystems.anunciosImageDir').'/'.$anuncio->imagen;

            }
            // sube la imagen al directorio indicado en el fichero de confi
            $imagenNueva= $request->file('imagen')->store(config('filesystems.anunciosImageDir'));

            // nos quedamos solo con el nombre del fichero para añadirlo a la BDD
            $datos['imagen']= pathinfo($imagenNueva, PATHINFO_BASENAME);
        }

        // SI el caso es que nos piden eliminar la imágen....
        if($request->filled('eliminarimagen') && $anuncio->imagen){
            // poner campo imagen a NULL
            $datos['imagen']=NULL;
            // recuperar el directorio para la imagen aBorrar
            $aBorrar= config('filesystems.anunciosImageDir').'/'.$anuncio->imagen;
        }

        // SI todo va BIEN al actualizar
        if($anuncio->update($datos)){

            //...y SI la variable aBorrar tiene valor...
            if(isset($aBorrar))
                // Borra la foto antigua a través de la Facada Storage
                Storage::delete($aBorrar);

        // SIno , si FALLA algo....
        }else{
            // ...y SI la variable imgenNueva tiene valor
            if(isset($imagenNueva))
                // Borra la imagen nueva
                Storage::delete($imagenNueva);
        }

        // encola las cookies
        Cookie::queue('lastUpdateID', $anuncio->id,0);
        Cookie::queue('lastUpdateDate', now(),0);

        // carga la misma vista [return back()] y muestra mensaje de exito
        // muestra al user un mensaje de los cambios realizados con variable de session flaseada
        return back()
            ->with('success', "El anuncio $anuncio->titulo creado el $anuncio->created_at, se ha editado correctamente");

    }



    /*
    |===========================================================
    |   ELIMINAR anuncio
    |   5.1_ delete(), 5.2_destroy(), 5.3_restore(), 5.4_purge()
    |===========================================================
     */
    /** _________________________________________________________
     *
     * 5.1_ delete()
     * ---------------------------------------------------------
     * Muestra el formulario de confirmación
     *
     * @param \Illuminate\Http\Request\AnuncioDeleteRequest $request
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Http\Response
     */
    public function delete(AnuncioDeleteRequest $request, Anuncio $anuncio)    {


        //Autorización mediante policy:
        if($request->user()->cant('delete',$anuncio))
            abort(401, 'No puedes borrar esta anuncio.');

        // recuera la URL anterior para futuras redirecciones
        Session::put('returnTo', URL::previous());


        //muestra formulario con mensaje de confirmaicón para el borrado de la anuncio
        // y recupera la anuncio para mostrar en la vista de blade
        return view('anuncios.delete',['anuncio'=>$anuncio]);
    }

    /** _________________________________________________________
     *
     * destroy()
     * ---------------------------------------------------------
     * Elimina la anuncio confirmada definitivamente.
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Anuncio $anuncio) {

        if($request->user()->cant('delete', $anuncio))
            abort(401, 'No puedes borrar una anuncio que no es tuya');


        // comporbar la validez de la firma de la URL
        if(!$request->hasValidSignature())
            abort(401, 'La firma de la URL no se pudo validar');



        // borra la anuncio (borrado blando)
        $anuncio->delete();


        // comprobamos si hay que retornan a algún sitio concreto
        // en caso contrario iremos a la lista de anuncios (ruta por defecto)
        $redirect = Session::has('returnTo') ?
                            redirect(Session::get('returnTo')) :     // por URL
                            redirect()->route('bikes.index');        // por nombre de ruta

        // usaremos la URL por si hay parámetros adicionales a tener en cuenta
        // por ejemplo con la paginación va el número de página y si usamos el nombre
        // iremos al inicio de la lista y no a la página actual

        Session::remove('returnTO'); // borramos la var de sesión si la hubiera


        // redirige a la operación anterior
        // muestra mensaje de exito de la operación con una variable de sesión flaseada
        return $redirect
            ->with('success', "El anuncio $anuncio->titulo ha sido  eliminado de la lista");
    }

    /** _________________________________________________________
     *
     * 5.3_restore() RESTAURAR ANUNCIO BORRADO
     * ---------------------------------------------------------
     * Restaura una anuncio borrada con soft delete.
     * @param  \Illuminate\Http\Request $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, int $id) {

        // recupera el anuncio borrado
        $anuncio = Anuncio::withTrashed()->findOrFail($id);

        if($request->user()->cant('restore', $anuncio))
            throw new AuthorizationException('No tienes permiso');

        // Restaura la anuncio
        $anuncio->restore();

        return back()->with(
            'success',
            "El $anuncio->titulo ha sido restaurado correctamente."
        );

    }

    /** _________________________________________________________
     *
     * 5.3_purge() ELIMINA DEFINITIVAMENTE DE LA BDD
     * ---------------------------------------------------------
     * Elimina el anuncio  definitivamente.
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function purge(Request $request) {

        // recupera el anuncio borrado
        $anuncio = Anuncio::withTrashed()->findOrFail($request->input('anuncio_id'));

        if($request->user()->cant('delete', $anuncio))
            throw new AuthorizationException('No tienes permiso');

        // Si se consigue eliminar definitivamente la anuncio y ésta tiene foto...
        if($anuncio->forceDelete() && $anuncio->imagen)
            // borra también la foto
            Storage::delete(config('filesystems.anunciosImageDir').'/'.$anuncio->imagen);


        // comprobamos si hay que retornan a algún sitio concreto
        // en caso contrario iremos a la lista de anuncios (ruta por defecto)
       // $redirect = Session::has('returnTo') ?
                           // redirect(Session::get('returnTo')) :     // por URL
                          //  redirect()->route('bikes.index');        // por nombre de ruta

        // usaremos la URL por si hay parámetros adicionales a tener en cuenta
        // por ejemplo con la paginación va el número de página y si usamos el nombre
        // iremos al inicio de la lista y no a la página actual

        //Session::remove('returnTO'); // borramos la var de sesión si la hubiera

        return back()->with(
            'success',
            "El anuncio $anuncio->titulo se ha eliminado definitivamente."
        );

    }


     /*
    |===========================================================
    |   BUSCAR anuncioS
    |   6.1_ search()
    |===========================================================
     */
    /** _________________________________________________________
     *
     * 6.1_ search()
     * ---------------------------------------------------------
     * Formulario para buscar anuncios a partir de marca y/o modelo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)    {

        // 6.1.1 valida lo que viene por request, max:16
        $request->validate(['titulo'=>'max:16','descripcion'=>'max:16']);

        // 6.1.2 Toma los valores de la Request
        $titulo = $request->input('titulo', '');
        $descripcion = $request->input('descripcion', '');

        /**
         * 6.1.3 Recupera los resultados de anuncio where(campo,condición,valor)
         *      _Añade titulo y descripcion al paginador, para mantener los resultados
         */
        $anuncios = Anuncio::where('titulo','like','%'.$titulo.'%')
                     ->where('descripcion','like','%'.$descripcion.'%')
                     ->paginate(config('pagination.anuncios'))
                     ->appends(['titulo'=>$titulo, 'descripcion'=>$descripcion]);

        // 6.1.4 Retorna la vista con el filtro aplicado
        return view('anuncios.list',['anuncios'=>$anuncios, 'titulo'=>$titulo,'descripcion'=>$descripcion]);
    }



}

