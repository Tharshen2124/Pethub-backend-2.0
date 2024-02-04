<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'post_id' => function() {
                return Post::inRandomOrder()->first()->post_id;
            },
            'comment_description' => fake()->text()
        ];
    }
}
