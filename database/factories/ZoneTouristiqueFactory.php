<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'lieu' => $this->faker->city,
            'images' => null, // Vous pouvez ajuster cela selon vos besoins
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
