<?php

namespace Database\Factories\Article;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'libelle' => $this->faker->text(20),
        ];
    }
}
