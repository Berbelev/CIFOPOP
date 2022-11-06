<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleUser;
Use Illuminate\Database\Eloquent\Factories\Sequence;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()    {
        //\App\Models\RoleUser::factory(10)->create();

        $roles = RoleUser::factory()
                    ->count(10)
                    ->state(new Sequence(
                        ['user_id'=>1, 'role_id'=>5 ],
                        ['user_id'=>2, 'role_id'=>4],
                        ['user_id'=>3, 'role_id'=>6],
                        ['user_id'=>4, 'role_id'=>1],
                        ['user_id'=>5, 'role_id'=>1],
                        ['user_id'=>6, 'role_id'=>1],
                        ['user_id'=>7, 'role_id'=>2],
                        ['user_id'=>8, 'role_id'=>2],
                        ['user_id'=>9, 'role_id'=>3],
                        ['user_id'=>10,'role_id'=>3],
                    ))
                    ->create();
    }
}
