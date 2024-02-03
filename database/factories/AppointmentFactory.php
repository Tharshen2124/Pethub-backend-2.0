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
            'user_id' => User::factory(),
            'pet_service_provider_ref' => User::factory(),
            'appointment_type' => 'healthcare',
            'date' => fake()->date(),
            'time' => fake()->time(),
            'important_details' => fake()->text(),
            'issue_description' => fake()->text(),
            'appointment_status' => fake()->randomElement(['accepted', 'pending', 'rejected']),
            'upload_payment_proof' => fake()->randomElement([
                'accepted', 
                'pending', 
                'rejected'
            ]),
        ];
    }
}
