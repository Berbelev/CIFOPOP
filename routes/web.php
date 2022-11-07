<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;


use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EditorController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;

use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*==========================================================================
| Autenticación
*///==========================================================================
Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*==========================================================================
| WelcomeControler Web Routes
|==========================================================================
| (Portada)
|   Single action Controler __invoke()
*/
Route::get('/', WelcomeController::class)->name('portada');

/*==========================================================================
| AnuncioControler Web Routes
|==========================================================================
|   CRUD
*/

// FORMULARIO para BUSQUEDA de motos
// buscar motos por marca(obligatorio) y modelo (opcional)
Route::match(['GET','POST'], '/anuncios/buscar',
                            [AnuncioController::class, 'search'])
        ->name('anuncios.search');



Route::resource('/anuncios', AnuncioController::class)
    ->names([
        'show'=>'anuncios.show',
        'index'=>'anuncios.index',
        'create'=>'anuncios.create',
        'store'=>'anuncios.store',
        'edit'=>'anuncios.edit',
        'update'=>'anuncios.update',
        'destroy'=>'anuncios.destroy'])
    ->parameters(['anuncios'=>'anuncio']);



// FORMULARIO de CONFIRMACIÓN para la ELIMINACIÓN de un anuncio
Route::get('anuncios/{anuncio}/borrar', [AnuncioController::class , 'delete'])
    ->name('anuncios.delete')
    ->middleware('throttle:3,1');

// ELIMINACIÓN DEFINITIVA DEL ANUNCIO
// va por DELETE
Route::delete('/anuncio/purge', [AnuncioController::class , 'purge'])
    ->name('anuncios.purge');

// RESTAURACIÓN DE LA ANUNCIO
Route::get('/anuncios/{anuncio}/restore', [AnuncioController::class,'restore'])
    ->name('anuncios.restore');



/*==========================================================================
| Grupo de rutas solo para el Administrador
|==========================================================================
|   Llevarán el prefijo 'admin'
*/
Route::prefix('admin')->middleware('auth', 'is_admin')->group(function(){

    // ver los anuncios eliminados(/admin/deletedanuncios)
    Route::get('deletedanuncios', [AdminController::class,'deletedAnuncios'])
        ->name('admin.deleted.anuncios');

});

/*==========================================================================
| Grupo de rutas solo para el Editor
|==========================================================================
|   Llevarán el prefijo 'editor'
*/
Route::prefix('editor')->middleware('auth', 'is_editor')->group(function(){

    // ver los anuncios eliminados(/admin/deletedanuncios)
    Route::get('deletedanuncios', [EditorController::class,'deletedAnuncios'])
        ->name('editor.deleted.anuncios');

});


/*==========================================================================
| ContactoController Web Routes
|==========================================================================
|   index() muestra formulario
|   send() recibe datos y envía mail
*/
// RUTA PRA EL FORUMUARIO DE CONTACTO
Route::get('/contacto',[ContactoController::class, 'index'])
->name('contacto');

// RUTA PARA EL ENVÍO DEL EMAIL DE CONTACTO
Route::post('/contacto',[ContactoController::class, 'send'])
->name('contacto.mail');



/*
|==========================================================================
|  RUTA DE FALLBACK (debe ser la ultima en el fichero)
|==========================================================================
*/
Route::fallback(WelcomeController::class);


