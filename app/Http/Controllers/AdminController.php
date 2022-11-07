<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;

class AdminController extends Controller
{
    public function deletedAnuncios(){

        // recupera las motos borradas
        $anuncios = Anuncio::onlyTrashed()
            ->paginate(config('pagination.anuncios',10));

        // carga la vista
        return view('admin.anuncios.deleted', ['anuncios'=>$anuncios]);
    }
}
