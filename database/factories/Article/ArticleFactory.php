<?php

namespace Database\Factories\Article;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "reference" => $this->faker->text(50),
            "designation" => $this->faker->text(200),
        ];
    }
}
