<?php

namespace App\Models;

use App\Models\User;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role'];

    // recupera los usuarios con este Rol
    public function users(){
        return $this->belongsToMany('User');
    }
}
