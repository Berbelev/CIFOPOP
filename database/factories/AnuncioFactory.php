<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Anuncio;

class AnuncioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(){
        return [
            'titulo'=>$this->faker->title,
            'descripcion'=>$this->faker->paragraph(1),
            'importe'=>$this->faker->randomFloat(2,1, 5000),
            'user_id'=>$this->faker->nummberBetween([1,10]),

        ];
    }
}
