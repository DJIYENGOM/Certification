<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ZoneTouristique;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'Nom' => $this->faker->name,
            'email' => $this->faker->email,
            'telephone' => $this->faker->phoneNumber,
            'nombre_de_personnes' => $this->faker->randomDigit,
            'date_debut' => $this->faker->date,
            'date_fin' => $this->faker->date,
            'reservation_annuler' => $this->faker->boolean,
            'validation' => 'encours',
            'zone' => function () {
                return ZoneTouristique::factory()->create()->id;
            },
            'visiteur' => function () {
                return User::factory()->create(['role' => 'visiteur'])->id;
            },
            'guide' => auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
