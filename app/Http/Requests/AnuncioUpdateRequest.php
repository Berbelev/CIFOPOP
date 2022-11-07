<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

use App\Policies\AnuncioPolicy;
use App\Http\Requests\AnuncioRequest;

class AnuncioUpdateRequest extends AnuncioRequest{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()    {

        // Retrona true solament si el usuario tiene permiso para actualizar
        return $this->user()->can('update', $this->anuncio);

    }

    /**
     * Mensaje en caso de que falle la autorización
     *
     * @return Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthotization()    {

        // Retrona true solament si el usuario tiene permiso para actualizar
        return new AuthorizationException('No puedes editar un anuncio que no es tuyo.');
        // FIXME:cifopop_1 NO APARECE EL MENSAJE DE LA EXCEPCIÓN, SOLO ERROR 403
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         * Con implicit binding se mapea automáticamente la instancia del modelo
         * a modo de propiedad de la request
         */
        $id = $this->anuncio->id;

        return [
            //
        ]+parent::rules();
    }
}
