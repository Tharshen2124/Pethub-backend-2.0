<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    /**
     * A basic test example.
     */
    use RefreshDatabase;

    public $table = "users";
    
    public function test_get_users_route(): void
    {
        User::factory(3)->create();

        $admin = User::create([
            'full_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '12345',
            'permission_level' => '3',
            'contact_number' => '0106673148',
            'description' => 'nothing',
            'image' => 'unce.png',
            'user_status' => 'approved'
        ]);

        $token = $admin->createToken('test-token')->plainTextToken;
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/admin/user');
        
        $user = [
            "user" => [
                [
                    "user_id",
                    "full_name",
                    "email",
                    "permission_level",
                    "image",
                    "description",
                    "contact_number",
                    "deposit_range",
                    "service_type",
                    "opening_hour",
                    "closing_hour",
                    "bank_name",
                    "beneficiary_acc_number",
                    "beneficiary_name",
                    "qr_code_image",
                    "user_status",
                    "created_at",
                    "updated_at"
                ]
            ]
        ];

        // use it for dynamic data and if you have a structure
        $response->assertJsonStructure($user);
    }

    public function test_get_specifc_user_route(): void
    {
        $user = User::factory()->create();

        $admin = User::create([
            'full_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '12345',
            'permission_level' => '3',
            'contact_number' => '0106673148',
            'description' => 'nothing',
            'image' => 'unce.png',
            'user_status' => 'approved'
        ]);

        $token = $admin->createToken('test-token')->plainTextToken;
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/admin/user/'.$user->user_id);

        $user = [
            "user" => [
                
                    "user_id",
                    "full_name",
                    "email",
                    "permission_level",
                    "image",
                    "description",
                    "contact_number",
                    "deposit_range",
                    "service_type",
                    "opening_hour",
                    "closing_hour",
                    "bank_name",
                    "beneficiary_acc_number",
                    "beneficiary_name",
                    "qr_code_image",
                    "user_status",
                    "created_at",
                    "updated_at"
                
            ]
        ];
        
        $response->assertJsonStructure($user);
    }
}
