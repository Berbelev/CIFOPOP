<?php

namespace App\Policies;

use App\Models\Anuncio;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnuncioPolicy{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Anuncio $anuncio)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //TODO:cifopop_policy create()
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Anuncio $anuncio)    {

        ///Solo puede actualizar anuncios: su propietario , el administrador o el editor
        // true si el usuario es el propietario o tiene uno de los roles
        return $user->isOwner($anuncio) ||
        $user->hasRole(['editor', 'admin']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Anuncio $anuncio)    {

        //Solo puede borrar las anuncios: su propietario, el administrador o el editor
        // true si el usuario es el propietario o tiene uno de los roles
        return $user->isOwner($anuncio) ||
               $user->hasRole(['editor', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Anuncio $anuncio)    {

        // true si el usuario es el propietaro o tiene uno de los roles admin o editor..
        return $user->isOwner($anuncio) ||
               $user->hasRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Anuncio  $anuncio
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Anuncio $anuncio)
    {
        //
    }
}
