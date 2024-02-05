<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\ZoneTouristique;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'user_id' => function () {
            //     return User::factory()->create()->id;
            // },
            'user_id' =>  Auth::user()->id,

            'zone_id' => function () {
                return ZoneTouristique::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
