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
        $titlesAndDescriptions = [
            [
                "Local Shelter Launches Charity Program to Support Stray Animals", 
                "The community's heartwarming response to stray animals has prompted the local animal shelter to launch a charity program. The program aims to raise funds for medical treatments, food, and shelter for stray pets in need. Donors can contribute through various channels, ensuring every dollar goes towards providing a better life for these animals.",
                "http://localhost/storage/news_image/news_4.jpg"
            ],
            [
                "Family Finds Joy Through Adoption: Rescued Dog Finds Forever Home", 
                "After months of searching for the perfect furry companion, a local family has found joy through adoption. They welcomed a rescued dog into their home, giving him a second chance at happiness. The heartwarming adoption story highlights the importance of choosing adoption and giving shelter animals a loving forever home.",
                'http://localhost/storage/news_image/news_5.jpg'
            ],
            [
                "Community Comes Together to Find Missing Cat: Owner's Plea for Help Heeded", 
                "A community rallied together to help find a missing cat after the owner's heartfelt plea for assistance. Volunteers organized search parties, shared posters, and spread the word on social media. Their efforts paid off when the missing cat was safely reunited with its grateful owner, showcasing the power of community support in times of need.",
                "http://localhost/storage/news_image/news_2.jpg"
            ],
            [
                "Pet Expo 2024: Celebrating Pets and Their Human Companions", 
                "Pet Expo 2024 welcomed pet enthusiasts from near and far to celebrate the cherished bond between pets and their human companions. The event, held at the expansive convention center, featured a diverse array of exhibits, interactive displays, and demonstrations showcasing the latest trends in the pet industry. From adoption zones where adorable animals found loving homes to thrilling agility demonstrations and informative seminars on pet care, the expo provided a fun-filled experience for attendees of all ages. Vendors and exhibitors delighted visitors with innovative products and services, reaffirming the profound connection between pets and their owners. The event will be from 8pm to 10pm on 24th february 2024. It will be at Stadium Shah Alam",
                "http://localhost/storage/news_image/news_3.jpg"
            ],
            [
                'Veterinary Clinic Hosts Free Microchipping Event to Promote Pet Safety', 
                "In an effort to promote pet safety and responsible ownership, a local veterinary clinic hosted a free microchipping event that drew a large crowd of pet owners seeking to protect their furry companions. The clinic, in collaboration with community partners, provided pet owners with the opportunity to have their pets microchipped at no cost, offering a simple and effective means of identification. As skilled veterinarians and volunteers worked diligently to implant microchips, pet owners expressed gratitude for the invaluable service, recognizing the importance of ensuring their pets' safety and well-being. The event served as a reminder of the vital role that responsible pet ownership plays in keeping pets safe and secure in their homes.",
                "http://localhost/storage/news_image/news_1.jpg"
            ],
        ];

        $randomTitleAndDescription = fake()->randomElement($titlesAndDescriptions);
        
        return [
            'user_id' => function() {
                return User::where('permission_level', 1)
                    ->inRandomOrder()
                    ->first()
                    ->user_id;
            },
            'news_title' => $randomTitleAndDescription[0],
            'news_description' => $randomTitleAndDescription[1],
            'image' => $randomTitleAndDescription[2],
            'news_status' => fake()->randomElement(['approved', 'pending', 'rejected']),
        ];
    }

    public function approvedNews(): Factory
    {
        return $this->state(function (array $attributes) {
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
                'news_status' => "approved",
            ];
        });
    }
}
