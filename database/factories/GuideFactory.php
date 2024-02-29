<?php

namespace Database\Factories;
use App\Models\ZoneTouristique;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guide>
 */
class GuideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // Vous pouvez ajuster cela en fonction de vos besoins
            'description' => $this->faker->paragraph,
            'duree_experience' => '10ans',
            'disponibilite' => 'disponible',
            'telephone' => '775649478',
            'image' => $this->faker->imageUrl(),
            'zone_id' => function () {
                return ZoneTouristique::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
