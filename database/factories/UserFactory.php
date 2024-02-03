<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'permission_level' => fake()->numberBetween(1, 3),
            'image' => fake()->randomElement([
                'http://localhost/storage/profile/clinic_1.jpg', 
                'http://localhost/storage/profile/clinic_2.jpg', 
                'http://localhost/storage/profile/clinic_3.jpg',
                'http://localhost/storage/profile/clinic_4.jpg', 
                'http://localhost/storage/profile/clinic_5.jpg', 
            ]),
            'deposit_range' => fake()->randomFloat(1, 10, 20),
            'service_type' => fake()->randomElement(['boarder', 'healthcare']),
            'description' => fake()->paragraph(),
            'contact_number' => fake()->numerify('+60-0##-#######'),
            'opening_hour' => fake()->time() ,
            'closing_hour' => fake()->time(),
            'bank_name' => fake()->randomElement(['maybank', 'CIMB', 'RHB', 'DuitNow']),
            'beneficiary_acc_number' => fake()->numberBetween(10000000, 100000000),
            'beneficiary_name' => fake()->name(),
            'qr_code_image' => fake()->randomElement([
                'http://localhost/storage/qr_code/qr_image_1.jpg', 
                'http://localhost/storage/qr_code/qr_image_2.jpg', 
                'http://localhost/storage/qr_code/qr_image_3.jpg', 
            ]),
            'user_status' => fake()->randomElement(['accepted', 'rejected', 'pending'])
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
