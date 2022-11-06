<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model{

    use HasFactory;

    protected $fillable=['role', 'descripcion'];

    // recupera los usuarios con este rol
    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
}