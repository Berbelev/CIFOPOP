<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\Role;

Use Illuminate\Database\Eloquent\Factories\Sequence;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\Role::factory(6)->create();
        $roles = Role::factory()
                    ->count(6)
                    ->state(new Sequence(
                        ['role'=> 'invitado' , 'descripcion'=> 'Tienen acceso a:'.
                                                               'anuncios.list (10 * pag),'.
                                                               'anuncios.show,'.
                                                               'y'.
                                                               'anuncios.search (por titulo y descripción)'
                        ],
                        ['role'=> 'registrado','descripcion'=> 'Tienen acceso a:'.
                                                                'su "home" (donse se muestran sus datos'.
                                                                            'y aviso de verificación),'.
                                                                'NO pueden crear anuncios ni ofertas'.
                                                                'hasta que no se verifiquen.'
                        ],
                        ['role'=> 'verificado','descripcion'=> 'Tienen acceso a:'.
                                                                'anuncios.create,'.
                                                                'anuncios.delete,'.
                                                                'anuncios.edit,'.
                                                                'anuncios.restore,'.
                                                                'anuncios.purge'.
                                                                'de sus propies anuncio.,'.
                                                                'También tienen acceso a:'.
                                                                'ofertas.create de otros usuarios'.
                                                                'y'.
                                                                'ofertas.aceptar,'.
                                                                'ofertas.rechazar'.
                                                                'de las oferas des sus propios anuncios.'
                        ],
                        ['role'=> 'editor',    'descripcion'=> 'Tienen acceso a:'.
                                                                'editor.anuncios.edit,'.
                                                                'editor.anuncios.delete,'.
                                                                'editor.anuncios.restore,'.
                                                                'editor.anuncios.purge,'.
                                                                'editor.ofertas.edit,'.
                                                                'editor.ofertas.delete,'.
                                                                'editor.ofertas.restore,'.
                                                                'editor.ofertas.purge'.
                                                                'de cualquier usuario.'
                        ],
                        ['role'=> 'admin',     'descripcion'=> 'Tienen acceso a:'.
                                                                'admin.anuncios.edit,'.
                                                                '...delete,'.
                                                                '...restore,'.
                                                                '...purge,'.
                                                                'admin.ofertas.edit,'.
                                                                '...delete,'.
                                                                '...restore,'.
                                                                '...purge'.
                                                                'de cualquier usuario.'.
                                                                'Y también tienen acceso a la gestión de usuarios:'.
                                                                'admin.usuarios.list,'.
                                                                'admin.rolesUsuarios.edit,'.
                                                                'admin.usuarios.bloquear,'

                        ],
                        ['role'=> 'bloqueado', 'descripcion'=> 'Tienen acceso a:'.
                                                                'su "home",'.
                                                                'PERO NO puede hacer operaciones'.
                                                                'con sus anuncios ni crear nuevos anuncios.'.
                                                                'Tampoco puede hacer ofertas.'.
                                                                'En su home se le avisará de las restricciones'.
                                                                'y de la posibilidad de usar:'.
                                                                'contacto'.
                                                                'y'.
                                                                'contacto.mail'
                        ],
                    ))
                    ->create();
    }
}
