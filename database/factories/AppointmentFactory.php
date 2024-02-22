<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
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
            'pet_service_provider_ref' => function() {
                return User::where('permission_level', 2)
                    ->inRandomOrder
                    ->first()
                    ->user_id;
            },
            'appointment_type' => 'healthcare',
            'date' => fake()->randomElement(['2024-02-27', '2024-02-28', '2024-03-01', '2024-03-02', '2024-03-03']),
            'time' => fake()->time(),
            'important_details' => fake()->randomElement([
                'allergic to cotton',
                'cannot mix well with other pets',
                'allergic to meats except chicken',
                'can get rashes when its hot',
                'cannot survive cold weather',
            ]),
            'issue_description' => fake()->randomElement([
                'has been vomitting a lot', 
                'scratching too much to the point there several spots where he is bleeding', 
                'cannot walk properly for 1 week', 
                'Hasnt been eating properly for 1 week', 
                'Has been not active at all (previously was very active) for 2 weeks'
            ]),
            'appointment_status' => fake()->randomElement(['approved', 'pending']),
            'upload_payment_proof' => "http://localhost/storage/payment_proof/payment_proof.jpg",
        ];
    }

    public function grooming_facilities(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'user_id' => function() {
                    return User::where('permission_level', 1)
                        ->inRandomOrder()
                        ->first()
                        ->user_id;
                },
                'pet_service_provider_ref' => function() {
                    return User::where('permission_level', 2)
                        ->where('service_type', 'grooming')
                        ->inRandomOrder
                        ->first()
                        ->user_id;
                },
                'appointment_type' => 'grooming',
                'date' => fake()->randomElement(['2024-02-27', '2024-02-28', '2024-03-01', '2024-03-02', '2024-03-03']),
                'time' => fake()->time(),
                'important_details' => fake()->randomElement([
                    'allergic to cotton',
                    'cannot mix well with other pets',
                    'allergic to meats except chicken',
                    'can get rashes when its hot',
                    'cannot survive cold weather',
                ]),
                'appointment_status' => fake()->randomElement(['approved', 'pending']),
                'upload_payment_proof' => "http://localhost/storage/payment_proof/payment_proof.jpg",
            ];
        });
    }
}
