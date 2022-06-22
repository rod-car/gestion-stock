<?php

namespace Database\Factories\Role;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nom_role' => $this->faker->unique()->text(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
