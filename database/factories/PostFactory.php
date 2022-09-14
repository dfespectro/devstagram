<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //esto llena la tabla con elementos aleatorios y falsos para comprobar para haacerlo en la terminal con sail artisan tinker
            'titulo' => $this->faker->sentence(5),
            'description' => $this->faker->sentence(20),
            'imagen' => $this->faker->uuid() . '.jpg', //comprobar la id unica
            'user_id' => $this->faker->randomElement([1, 2])
        ];
    }
}
