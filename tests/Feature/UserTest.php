<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\News;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_get_news_route(): void
    {
        $userIds = User::factory()->count(10)->create()->pluck('user_id');
        $newsCategories = ['Adoption', 'Event', 'Missing', 'Promotion', 'Charity Program'];

        foreach ($newsCategories as $category) {
            Category::create(['category_name' => $category, 'category_type' => 'news', 'is_deleted' => 0]);
        }

        foreach ($userIds as $userId) {
            // Create 5 news for each user and attach categories
            $news = News::factory()->count(5)->create(['user_id' => $userId]);
            $news->each(function ($news) {
                $news->categories()->attach(
                    Category::where('category_type', 'news')->inRandomOrder()->take(3)->pluck('category_id')
                );
            });
        }

        $user = User::create([
            'full_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '12345',
            'permission_level' => '1',
            'contact_number' => '0106673148',
            'description' => 'nothing',
            'image' => 'unce.png',
            'user_status' => 'approved'
        ]);

        $token = $user->createToken('test-token')->plainTextToken;
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/news');
        $user = [
            "news" => [
                [
                    "news_id",
                    "user_id",
                    "news_title",
                    "news_description",
                    "image",
                    "news_status",
                    "created_at",
                    "updated_at",
                    "user" => [
                        "user_id",
                        "full_name",
                        "email",
                    ],
                    "categories" => [
                        [
                            "category_id",
                            "category_name",
                            "category_type",
                        ],
                    ]
                ]
            ]
        ];

        // use it for dynamic data and if you have a structure
        $response->assertJsonStructure($user);
    }

    public function test_get_specific_news_route() 
    {
        $user = User::factory()->create();
        $news = News::factory()->approvedNews()->create(['user_id' => $user->user_id]);

        Log::debug($news);

        $news->categories()->attach(
            Category::where('category_type', 'news')->inRandomOrder()->take(3)->pluck('category_id')
        );

        $user2 = User::create([
            'full_name' => 'admin2',
            'email' => 'admin2@gmail.com',
            'password' => '12345',
            'permission_level' => '1',
            'contact_number' => '0106673148',
            'description' => 'nothing',
            'image' => 'unce.png',
            'user_status' => 'approved'
        ]);

        $token = $user2->createToken('test-token')->plainTextToken;
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/news/'.$news->news_id);

        $response->dump();
        
        $news = [
            "news" => [
                "news_id",
                "user_id",
                "news_title",
                "news_description",
                "image",
                "news_status",
                "created_at",
                "updated_at",
                "user" => [
                    "user_id",
                    "full_name",
                    "email",
                ],
                "categories" => [
                    [
                        "category_id",
                        "category_name",
                        "category_type",
                    ],
                ]  
            ]
        ];

        // use it for dynamic data and if you have a structure
        $response->assertJsonStructure($news);
    }

    public function test_post_news_route()
    {
        $user = User::create([
            'full_name' => 'user1',
            'email' => 'user1@gmail.com',
            'password' => '12345',
            'permission_level' => '1',
            'contact_number' => '0106673148',
            'description' => 'nothing',
            'image' => 'unce.png',
            'user_status' => 'approved'
        ]);

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/news', [
            'user_id' => $user->user_id,
            'news_title' => "This is a title",
            'news_description' => "This is a description",
            'image' => "image.png", 
            'news_status' => "pending",
            "categories" => '1,2'
        ]);

        $response->assertJsonFragment([
            'message' => "Successfully sent to the administrator! Wait for a few days for admin to approve of the news."
        ]);
    }
}
