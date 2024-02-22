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
            'email' => $this->faker->userName . '@gmail.com',
            'password' => bcrypt("220204Th#"), // password
            'permission_level' => "1",
            'image' => 'http://localhost/storage/profile/tharshen.jpg',
            'description' => fake()->randomElement([
                "As a pet owner, I cherish every moment with my furry friend, showering them with love and affection every day. Our bond is unbreakable, filled with joy from our morning walks to our cozy evening cuddles.",
                "Being a responsible pet owner means ensuring my beloved companion receives top-notch care. I prioritize their well-being with regular vet check-ups, nutritious meals, and plenty of playtime, all aimed at keeping them happy and healthy.",
                "With a heart full of compassion, I've opened my home to rescue animals in need, offering them a second chance at happiness. Through patience, understanding, and unwavering devotion, I provide my furry family members with the love and care they deserve.",
                "As an animal lover, my home is a sanctuary for furry companions. Whether I'm adopting senior pets or fostering homeless animals, I dedicate my time and resources to making a difference in their lives, one paw at a time.",
                "My passion for pets drives me to advocate for their welfare and spread awareness about responsible pet ownership. From organizing pet playdates to volunteering at local shelters, I'm deeply committed to ensuring every furry friend finds a loving home.",
            ]),
            'contact_number' => fake()->numerify('0#########'),
            'user_status' => "approved"
        ];
    }
    
    public function healthcare_facilities(): Factory
    {
        return $this->state(function (array $attributes) {
            $data = [
                [
                    "Heshmael's Clinic For Pets Sdn Bhd",
                    "123 Jalan Selangor, Taman Maju, 43000 Kajang, Selangor, Malaysia",
                    'http://localhost/storage/profile/clinic_1.jpg',
                ],
                [
                    "Pets Clinic For Pets Animal Kuchai Lama",
                    "456 Jalan Semarak, Bandar Baru Bangi, 43650 Selangor, Malaysia",
                    'http://localhost/storage/profile/clinic_2.jpg', 
                ],
                [
                    "Klinik Haiwan dan Surgeri Kota Damansara",
                    "789 Persiaran Putra, Seksyen 7, 40100 Shah Alam, Selangor, Malaysia",
                    'http://localhost/storage/profile/clinic_3.jpg',
                ],
                [
                    "Pets Health Veterinary Clinic and Surgery",
                    "321 Jalan Raja Muda, Batu Caves, 68100 Gombak, Selangor, Malaysia",
                    'http://localhost/storage/profile/clinic_4.jpg', 
                ],
                [
                    "Petsville Animal Clinic",
                    "555 Jalan Meru, Taman Meru, 41050 Klang, Selangor, Malaysia",
                    'http://localhost/storage/profile/clinic_5.jpg', 
                ],
            ];
    
            $randomData = fake()->randomElement($data);
            return [
                'full_name' => $randomData[0],
                'email' => $this->faker->userName . '@gmail.com',
                'password' => bcrypt("220204Th#"), // password
                'permission_level' => "2",
                'image' => $randomData[2],
                'deposit_value' => fake()->randomFloat(1, 10, 20),
                'service_type' => "healthcare",
                'description' => fake()->randomElement([
                    "Our state-of-the-art pet healthcare facility is dedicated to providing top-quality veterinary care for furry companions of all shapes and sizes. With a team of experienced veterinarians and compassionate staff, we strive to ensure the health and well-being of every pet that walks through our doors.",
                    "At our pet healthcare facility, we understand the importance of preventive care in maintaining your pet's health. From routine vaccinations to wellness exams, we offer a comprehensive range of services designed to keep your furry friend happy and healthy for years to come.",
                    "When it comes to emergencies, our pet healthcare facility is here for you and your furry family members. Our 24/7 emergency services provide peace of mind knowing that expert care is available whenever your pet needs it most, ensuring prompt and compassionate treatment in times of crisis.",
                    "With our advanced diagnostic capabilities and cutting-edge technology, our pet healthcare facility is equipped to handle a wide range of medical conditions and illnesses. From digital X-rays to ultrasound imaging, we provide accurate diagnoses and personalized treatment plans tailored to your pet's unique needs.",
                    "At our pet healthcare facility, we believe in the importance of a holistic approach to pet wellness. In addition to traditional veterinary services, we offer alternative therapies such as acupuncture, physical therapy, and herbal medicine, providing comprehensive care to address your pet's physical, emotional, and behavioral needs.",
                ]),
                'contact_number' => fake()->numerify('+60-0##-#######'),
                'opening_hour' => fake()->randomElement([
                    '12:00:00',
                    '10:00:00',
                    '11:00:00',
                    '08:00:00',
                    '09:00:00',
                ]),
                'closing_hour' => fake()->randomElement([
                    '17:00:00',
                    '18:00:00',
                    '19:00:00',
                ]),
                'bank_name' => fake()->randomElement(['Maybank', 'CIMB', 'DuitNow']),
                'beneficiary_acc_number' => fake()->numberBetween(10000000, 100000000),
                'facility_location' => $randomData[1],
                'beneficiary_name' => fake()->name(),
                'qr_code_image' => fake()->randomElement([
                    'http://localhost/storage/qr_code/qr_image_1.png', 
                    'http://localhost/storage/qr_code/qr_image_2.png', 
                    'http://localhost/storage/qr_code/qr_image_3.jpg', 
                ]),
                'user_status' => 'approved'
            ];
        });
    }

    public function grooming_facilities(): Factory
    {
        return $this->state(function (array $attributes) {
            $data = [
                [
                    "Dogwood",
                    "888 Jalan Bunga Raya, Seksyen 2, 47000 Sungai Buloh, Selangor, Malaysia",
                    'http://localhost/storage/profile/grooming_1.jpg',
                ],
                [
                    "Dogsbody Dog Grooming",
                    "234 Persiaran Seroja, Bandar Seri Putra, 43000 Bangi, Selangor, Malaysia",
                    'http://localhost/storage/profile/grooming_2.jpg', 
                ],
                [
                    "Diva Pets",
                    "777 Jalan Sungai Besi, 43300 Seri Kembangan, Selangor, Malaysia",
                    'http://localhost/storage/profile/grooming_3.jpg',
                ],
                [
                    "Omot Pet Shop",
                    "101 Jalan Bakti, Kampung Baru, 43200 Cheras, Selangor, Malaysia",
                    'http://localhost/storage/profile/grooming_4.jpg', 
                ],
                [
                    "PawPals",
                    "999 Jalan Impian, Kota Damansara, 47810 Petaling Jaya, Selangor, Malaysia",
                    'http://localhost/storage/profile/grooming_5.jpg', 
                ],
            ];
    
            $randomData = fake()->randomElement($data);
            return [
                'full_name' => $randomData[0],
                'email' => $this->faker->userName . '@gmail.com',
                'password' => bcrypt("220204Th#"), // password
                'permission_level' => "2",
                'image' => $randomData[2],
                'deposit_value' => fake()->randomFloat(1, 10, 20),
                'service_type' => "grooming",
                'description' => fake()->paragraph(),
                'contact_number' => fake()->numerify('0#########'),
                'opening_hour' => fake()->randomElement([
                    '12:00:00',
                    '10:00:00',
                    '11:00:00',
                    '08:00:00',
                    '09:00:00',
                ]),
                'closing_hour' => fake()->randomElement([
                    '17:00:00',
                    '18:00:00',
                    '19:00:00',
                ]),
                'bank_name' => fake()->randomElement(['Maybank', 'CIMB', 'DuitNow']),
                'beneficiary_acc_number' => fake()->numberBetween(10000000, 100000000),
                'facility_location' => $randomData[1],
                'beneficiary_name' => fake()->name(),
                'qr_code_image' => fake()->randomElement([
                    'http://localhost/storage/qr_code/qr_image_1.png', 
                    'http://localhost/storage/qr_code/qr_image_2.png', 
                    'http://localhost/storage/qr_code/qr_image_3.jpg', 
                ]),
                'user_status' => 'approved'
            ];
        });
    }

    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'full_name' => "Tharshen",
                'email' => "admin@gmail.com",
                'password' => bcrypt("220204Th#"), // password
                'permission_level' => "3",
                'image' => 'http://localhost/storage/profile/tharshen.jpg',
                'user_status' => "approved"
            ];
        });
    }

    public function serviceProviderIsPending(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'full_name' => fake()->name(),
                'email' => $this->faker->userName . '@gmail.com',
                'password' => bcrypt("220204Th#"), // password
                'permission_level' => "2",
                'image' => fake()->randomElement([
                    'http://localhost/storage/profile/clinic_1.jpg', 
                    'http://localhost/storage/profile/clinic_2.jpg', 
                    'http://localhost/storage/profile/clinic_3.jpg',
                    'http://localhost/storage/profile/clinic_4.jpg', 
                    'http://localhost/storage/profile/clinic_5.jpg', 
                ]),
                'deposit_value' => fake()->randomFloat(1, 10, 20),
                'service_type' => "healthcare",
                'description' => fake()->paragraph(),
                'contact_number' => fake()->numerify('0#########'),
                'opening_hour' => fake()->time(),
                'closing_hour' => fake()->time(),
                'bank_name' => fake()->randomElement(['Maybank', 'CIMB', 'DuitNow']),
                'beneficiary_acc_number' => fake()->numberBetween(10000000, 100000000),
                'facility_location' => fake()->address(),
                'beneficiary_name' => fake()->name(),
                'qr_code_image' => fake()->randomElement([
                    'http://localhost/storage/qr_code/qr_image_1.png', 
                    'http://localhost/storage/qr_code/qr_image_2.png', 
                    'http://localhost/storage/qr_code/qr_image_3.jpg', 
                ]),
                'user_status' => 'pending'
            ];
        });
    }

    public function wei_jie()
    {
        return $this->state(function (array $attributes) {
            return [
                'full_name' => "Wei Jie",
                'email' => "weijie@gmail.com",
                'password' => bcrypt("220204Th#"), // password
                'permission_level' => "1",
                'image' => 'http://localhost/storage/profile/tharshen.jpg',
                'description' => fake()->paragraph(),
                'contact_number' => fake()->numerify('+60-0##-#######'),
                'user_status' => "approved"
            ];
        });
    }

    public function chong()
    {
        return $this->state(function (array $attributes) {
            return [
                'full_name' => "Chong",
                'email' => "chong@gmail.com",
                'password' => bcrypt("220204Th#"), // password
                'permission_level' => "1",
                'image' => 'http://localhost/storage/profile/tharshen.jpg',
                'description' => fake()->paragraph(),
                'contact_number' => fake()->numerify('+60-0##-#######'),
                'user_status' => "approved"
            ];
        });
    }
}
