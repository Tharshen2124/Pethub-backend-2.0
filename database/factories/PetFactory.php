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
        $data = [
            [
                "jack",
                'cat',
                'American Shorthair',
                'very cute and very friendly with other cats. Does not like playing ball. ',
                '7 years old',
                'http://localhost/storage/pet_profile/pet_1.jpg',
            ],
            [
                "rusell",
                'dog',
                'Rotweiler',
                'Can be very protective of owners. Scared of other dogs.',
                '6 years old',
                'http://localhost/storage/pet_profile/pet_4.jpg'
            ],
            [
                "samuel",
                'cat',
                'Birman',
                'Adopted when he was a only 3 months. Very good with other cats.',
                '2 years old',
                'http://localhost/storage/pet_profile/pet_3.jpg',
            ],
            [
                "Sam Smith",
                'cat',
                'white shorthair',
                'can be very lazy. Doesnt move a lot.',
                '4 years old',
                'http://localhost/storage/pet_profile/pet_2.jpg'
            ],
            [
                "Drake",
                'dog',
                'Golden Retriever',
                'very active at sports.',
                '5 months old',
                'http://localhost/storage/pet_profile/pet_5.jpg',
            ],
        ];

        $randomData = fake()->randomElement($data);

        return [
            'pet_name' => $randomData[0],
            'user_id' => function() {
                return User::where('permission_level', 1)
                    ->inRandomOrder()
                    ->first()
                    ->user_id;
            },
            'type' => $randomData[1],
            'breed' => $randomData[2], 
            'description'=> $randomData[3],
            'age' => $randomData[4],
            'image' => $randomData[5],
        ];
    }
}
