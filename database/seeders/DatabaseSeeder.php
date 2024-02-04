<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pet;
use App\Models\News;
use App\Models\Post;
use App\Models\User;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Category;
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

        // Create hardcoded categories for 'news' and 'posts'
        $newsCategories = ['Adoption', 'Event', 'Missing', 'Promotion', 'Charity Program'];
        $postCategories = ['Exotic pets', 'Small pets', 'Dogs', 'Cats', 'Food'];

        foreach ($newsCategories as $category) {
            Category::create(['category_name' => $category, 'category_type' => 'news', 'is_deleted' => 0]);
        }

        foreach ($postCategories as $category) {
            Category::create(['category_name' => $category, 'category_type' => 'posts', 'is_deleted' => 0]);
        }

        // Create news, posts, comments for each user
        foreach ($userIds as $userId) {
            // Create 5 news for each user and attach categories
            $news = News::factory()->count(5)->create(['user_id' => $userId]);
            $news->each(function ($news) {
                $news->categories()->attach(
                    Category::where('category_type', 'news')->inRandomOrder()->take(3)->pluck('category_id')
                );
            });

            // Create 5 posts for each user and attach categories
            $posts = Post::factory()->count(5)->create(['user_id' => $userId]);
            $posts->each(function ($post) {
                $post->categories()->attach(
                    Category::where('category_type', 'posts')->inRandomOrder()->take(3)->pluck('category_id')
                );

                // Create 5 comments for each post
                Comment::factory()->count(5)->create(['user_id' => $post->user_id, 'post_id' => $post->post_id]);
            });
        }

        // Creates admin account
        User::factory()->admin()->count(1)->create();

        // Creates service providers with pending acc
        User::factory()->serviceProviderIsPending()->count(3)->create();

        Report::factory()->count(10)->create();
    }


}
