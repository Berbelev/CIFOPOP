<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anuncio extends Model{

    use HasFactory, SoftDeletes;

    // Campos a los que se permite hacer asignación masiva desde la request a la BDD
    protected $fillable =['titulo','descripcion', 'importe', 'imagen',
                         'user_id'];

    // retorna el usuario propietario del anuncio
    public function user(){
        return $this->belongsTo('\App\Models\User');
    }

}
