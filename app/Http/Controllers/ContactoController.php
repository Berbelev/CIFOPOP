<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;



class ContactoController extends Controller{

    /* ===========================================================
    |   INDEX
    *///=========================================================
    /**
     * Display a listing of the resource.
     * Muestra el formulario de contacto.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        return view('contacto');
    }

    public function send(Request $request){

        $request->validate([
            'email'=>'required|email:rfc',
            'fichero'=>'sometimes|file|mimes:pdf'
        ]);

        $mensaje = new \stdClass(); // objeto con los datos
        $mensaje->asunto =$request->asunto;
        $mensaje->email =$request->email;
        $mensaje->nombre =$request->nombre;
        $mensaje->mensaje =$request->mensaje;

        // si en envió fichero recupera la ruta(en el directorio temporal)
        $mensaje->fichero = $request->hasFile('fichero')?
                            $request->file('fichero')->getRealPath() :
                            NULL;

        Mail::to('info@cifopop.com')->send(new Contact($mensaje));

        return redirect()
            ->route('portada')
            ->with('success', 'Mensaje enviado correctamente.');
    }

}
