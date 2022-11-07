<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

use App\Policies\UserPolicy;

class UserRequest extends FormRequest{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required|max:64',
            'email'      => 'required|max:32|unique:users',
            'username'   => 'required|max:32|unique:users',
            'poblacion'  => 'required|max:16',
            //'telefono'   => 'required|integer|max:9', TODO:cifopop_validación
            'foto'       => 'sometimes|
                                file|
                                image|
                                mimes:jpg,png,gif,webp|
                                max:2048'
        ];
    }

    /**
     * Return the messages
     */
    public function messages(){
        return [
            'name.required'=>'El name es obligatorio.',
            'name.max'=>'El name debe tener como máximo 64 carácteres.',
            'email.required'=>'El email es obligatorio.',
            'email.unique'=>'El email indicado ya está existe.',
            'email.max'=>'EL email debe tener como máximo 32 carácteres.',
            'username.required'=>'El username es obligatorio.',
            'username.unique'=>'El username indicado ya está existe.',
            'username.max'=>'El username debe tener como máximo 32 carácteres.',
            'poblacion.required'=>'La poblacion es obligatoria.',
            'poblacion.max'=>'La poblacion debe tener como máximo 16 carácteres.',
            'imagen.image'=>'El fichero debe ser una imagen',
            'imagen.mines'=>'La imagen debe ser de tipo jpg, png, gif o webp.',
            'imagen.max'=>'La imagen debe tener un tamaño maximo de 2048.',

        ];
    }
}
