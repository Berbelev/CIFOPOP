<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

use App\Policies\AnuncioPolicy;

class AnuncioRequest extends FormRequest{

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
            'titulo'       => 'required|min:3|max:255',
            'descripcion'      => 'required|min:3|max:255',
            'importe'      => 'required|numeric|min:0',
            'imagen'      => 'sometimes|
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
            'titulo.required'=>'El titulo es obligatorio.',
            'titulo.min'=>'El titulo debe tener como mínimo tres carácteres.',
            'titulo.max'=>'El titulo debe tener como máximo 255 carácteres.',
            'descripcion.required'=>'La descripcion es obligatorio.',
            'descripcion.min'=>'La descripcion debe tener como mínimo tres carácteres.',
            'descripcion.max'=>'La descripcion debe tener como máximo 255 carácteres.',
            'importe.required'=>'El precio es obligatorio.',
            'importe.numeric'=>'El precio debe ser un número con dos decimales máximo.',
            'importe.min'=>'El precio debe ser mayor o igual a cero.',
            'imagen.image'=>'El fichero debe ser una imagen',
            'imagen.mines'=>'La imagen debe ser de tipo jpg, png, gif o webp.',
            'imagen.max'=>'La imagen debe tener un tamaño maximo de 2048.',

        ];
    }
}
