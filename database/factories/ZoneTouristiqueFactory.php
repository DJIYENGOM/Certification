<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ZoneTouristique>
 */
class ZoneTouristiqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'statut' => 'non publier',
            'duree' => $this->faker->randomNumber(2) . ' jours',
            'cout' => $this->faker->randomFloat(2, 10, 500),
            'images' => null, // Vous pouvez ajuster cela selon vos besoins
            'user_id' => function () {
               return User::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
