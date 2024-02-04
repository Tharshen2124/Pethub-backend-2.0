<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pet_name' => fake()->name(),
            'user_id' => function() {
                return User::where('permission_level', 1)
                    ->inRandomOrder()
                    ->first()
                    ->user_id;
            },
            'type' => fake()->randomElement(['dog', 'cat', 'goat']),
            'breed' => fake()->randomElement(['doberman', 'siberian husky', 'white shortbread', 'none', 'black type']), 
            'description'=> fake()->text(),
            'age' => fake()->numberBetween(1, 10),
            'image' => fake()->imageUrl(640, 480, 'animals', true)
        ];
    }
}
