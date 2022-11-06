<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RoleUser;
Use Illuminate\Database\Eloquent\Factories\Sequence;


class RoleUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            /*
            'user_id'=>$this->faker->state(new Sequence(
                ['user_id'=>1],
                ['user_id'=>2],
                ['user_id'=>3],
                ['user_id'=>4],
                ['user_id'=>5],
                ['user_id'=>6],
                ['user_id'=>7],
                ['user_id'=>8],
                ['user_id'=>9],
                ['user_id'=>10],
            )),
            'role_id'=>$this->faker->randomElement([1,2,3,4,5,6]),
            */
            'created_at'=>now(),
        ];
    }
}
