<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pet;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Certificate;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $userIds = User::factory()->count(10)->create()->pluck('user_id');
        $serviceProviderIds = User::factory()->serviceProvider()->count(10)->create()->pluck('user_id');

        // Create pets for each user
        $petIds = [];
        foreach ($userIds as $userId) {
            $petIds[] = Pet::factory()->create(['user_id' => $userId])->pet_id;
        }

        // Create 5 appointments for each user, service provider, and pet
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 5; $j++) {
                Appointment::factory()->create([
                    'user_id' => $userIds[$i],
                    'pet_service_provider_ref' => $serviceProviderIds->random(),
                    'pet_id' => $petIds[$i],
                ]);
            }
        }
    }
}
