<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ZoneTouristique;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commentaire>
 */
class CommentaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'contenu' => $this->faker->paragraph,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'zone_id' => function () {
                return ZoneTouristique::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
