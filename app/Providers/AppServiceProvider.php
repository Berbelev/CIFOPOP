<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // para la paginación
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        // indcar que usampos bootstrap para la paginación
        Paginator::useBootstrap();

         /**
         *| Mostrar la variable autor en todas las vistas
         *| con share() de la facada View
         */
        View::share('autor','Berbelev');

        /**
        *| Definición de un macro para las respuestas
        *|
        */
       Response::macro('mayusculas', function($datos){
           return Response::make(strtoupper($datos));
       });

    }

}
