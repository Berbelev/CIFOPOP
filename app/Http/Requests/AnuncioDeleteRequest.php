<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

use App\Policies\AnuncioPolicy;


class AnuncioDeleteRequest extends FormRequest{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()    {

        return $this->user()->can('delete', $this->anuncio);

    }
     /**
     * Mensaje en caso que falle la autorización
     *
     * @return Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()    {
        return new AuthorizationException('No puedes eliminar un anuncio que no es tuyo.');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
