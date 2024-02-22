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
            'date' => fake()->date(),
            'time' => fake()->time(),
            'important_details' => fake()->text(),
            'issue_description' => fake()->text(),
            'appointment_status' => fake()->randomElement(['approved', 'pending']),
            'upload_payment_proof' => "http://localhost/storage/payment_proof/payment_proof.jpg",
        ];
    }

    public function grooming_facilities(): Factory
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
                    ->where('service_type', 'grooming')
                    ->inRandomOrder
                    ->first()
                    ->user_id;
            },
            'appointment_type' => 'grooming',
            'date' => fake()->date(),
            'time' => fake()->time(),
            'important_details' => fake()->text(),
            'appointment_status' => fake()->randomElement(['approved', 'pending']),
            'upload_payment_proof' => "http://localhost/storage/payment_proof/payment_proof.jpg",
        ];
    }
}
