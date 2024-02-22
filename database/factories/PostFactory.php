<?php

namespace Database\Factories;

use App\Models\User;
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
    public function definition(): array
    {
        $titlesAndDescriptions = [
            ['Backyard Adventures with Oliver', "Playtime in the backyard with my mischievous kitty, Oliver! He's always up to something, exploring every nook and cranny with endless curiosity."],
            ['New Family Member: Meet Max', "Just adopted this adorable rescue pup! Meet Max, the newest member of our family. He's already settling in and spreading joy everywhere he goes."],
            ['Lazy Sundays with Luna', "Sunday snuggles with my feline friend, Luna. She's the queen of nap time and always finds the coziest spots around the house."],
            ['Training Time with Bailey', "Training session with my energetic pup, Bailey! She's learning so fast and making me proud with every trick she masters."],
            ['Morning Cuddles with Rocky', "Morning cuddles with my loyal companion, Rocky. He's always by my side, rain or shine, bringing warmth and love to every moment."]
        ];

        $randomTitleAndDescription = fake()->randomElement($titlesAndDescriptions);

        return [
            'user_id' => function() {
                return User::where('permission_level', 1)
                    ->inRandomOrder()
                    ->first()
                    ->user_id;
            },
            'post_title' => $randomTitleAndDescription[0],
            'post_description' => $randomTitleAndDescription[1],
        ];
    }
}
