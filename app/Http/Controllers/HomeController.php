<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        // recuperar los Anuncios NO borrados del usuario
        $anuncios = $request->user()->anuncios()
                ->paginate(config('pagination.anuncios', 10));

        // recuperar los Anuncios  borrados del usuario
        $deleteAnuncios = $request->user()->anuncios()->onlyTrashed()->get();

        // recuera la URL anterior para futuras redirecciones
        Session::put('returnTo', URL::previous());

    return view('home', ['anuncios'=>$anuncios, 'deleteAnuncios'=>$deleteAnuncios]);

    }
}
