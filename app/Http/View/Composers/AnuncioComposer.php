<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Anuncio;


class AnuncioComposer{
    /**
     * Vincula la información a la vista
     *
     * @param View $view
     *
     *
     */
    public function compose(View $view)    {

        $view->with('total', Anuncio::count());
    }


}
