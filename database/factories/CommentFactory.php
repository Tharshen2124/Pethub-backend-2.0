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
            'comment_description' => fake()->randomElement([
                "Congratulations on your new family member! Max is so lucky to have found a loving home.",
                "Aww, Max is precious! Thank you for choosing adoption. Wishing you many happy years together!",
                "Rescue dogs are the best! Max is going to bring so much love and joy into your life.",
                "He's so cute! Thank you for giving him a second chance. Can't wait to see more updates!",
                "Welcome home, Max! You hit the jackpot with your new family. Can't wait to see all the adventures ahead!",
                "Luna is living the dream life! So cozy and content.",
                "There's nothing better than a lazy Sunday with a cuddly cat! Luna looks so content and peaceful.",
                "I wish I could join Luna for a snuggle session! She looks so soft and comfy.",
                "Luna is giving me major relaxation goals! Cats really know how to enjoy life.",
                "I love seeing Luna's Sunday routine! She's such a beautiful and serene kitty.",
                "Bailey is such a smart pup! You're doing an amazing job with her training.",
                "Look at her focus! Bailey is going to be a superstar in no time. Keep up the great work!",
                "I love seeing your training progress with Bailey! She's one clever pup.",
                "You two make such a great team! Bailey's determination is inspiring.",
                "Bailey is so lucky to have such a dedicated owner! Can't wait to see all the tricks she learns.",
                "Rocky is the epitome of loyalty! What a wonderful bond you two share.",
                "There's nothing like starting the day with some puppy love! Rocky is such a sweet and faithful friend.",
                "I love seeing your morning cuddles with Rocky! He's such a devoted companion.",
                "Rocky's love and devotion shine through in every photo! You're so lucky to have each other.",
                "Rocky's morning cuddles are the best way to start the day! He's such a special pup.",
                "Oliver is such a playful little mischief-maker! I bet he keeps you on your toes.",
                "I love seeing Oliver's playful antics! He's a bundle of energy and entertainment.",
                "Your backyard looks like a kitty paradise! Oliver is living his best life.",
                "Oliver's playful spirit is contagious! He's such a character.",
                "I adore seeing Oliver's playful side! He's such a fun and spirited kitty.",
            ])
        ];
    }
}
