<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
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
            'report_title' => fake()->word(),
            'report_description' => fake()->text(),
        ];
    }
}
