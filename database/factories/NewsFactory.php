<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function() {
                return User::where('permission_level', 1)
                    ->inRandomOrder()
                    ->first()
                    ->user_id;
            },
            'news_title' => fake()->title(),
            'news_description' => fake()->text(),
            'image' => fake()->imageUrl(640, 480, 'animals', true), 
            'news_status' => fake()->randomElement(['approved', 'pending', 'rejected']),
        ];
    }
}
