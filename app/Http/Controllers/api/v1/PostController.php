<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\AllPostResource;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\AllPostCollection;

class PostController extends Controller
{
    // display all posts with the earliest comment
    public function index()
    {
        $posts = Post::with('categories', 'user')->orderBy('created_at', 'desc')->get();

        return response()->json([
            "posts" => AllPostResource::collection($posts)
        ]);
    }

    // Store a new post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'post_title' => 'required',
            'post_description' => 'required',
            'categories' => 'required|array'
        ]);

        $post = Post::create([
            'user_id' => $validated['user_id'],
            'post_title' => $validated['post_title'],
            'post_description' => $validated['post_description'],
        ]);

        $post->categories()->sync($request->categories);

        return response()->json([
            'message' => "Successfully created post!",
        ], 201);

        $post = Post::with('catgories', 'user')->get();
    }

    // Show a post with all its comments
    public function show(string $id)
    {
        $post = Post::with('user', 'categories', 'comments.user')->find($id);

        return response()->json([
           'post' => new PostResource($post)
        ]);
    }

    // Update a post
    public function update(Request $request, string $id)
    {
        $post = Post::find($id) ?? null;
        
        if($post) {
            $validated = $request->validate([
                'user_id' => 'required',
                'post_title' => 'required',
                'post_description' => 'required',
                'categories' => 'required|array'
            ]);
    
            $post->update([
                'user_id' => $validated['user_id'],
                'post_title' => $validated['post_title'],
                'post_description' => $validated['post_description'],
            ]);

            $post->categories()->sync($request->categories);

            return response()->json([
                'message' => "Successfully updated post!",
            ]);

        } else {
            return response()->json([
                'Error' => "Post not found"
            ], 404);
        }
    }

    // Delete a post and its associated comments
    public function destroy(string $id)
    {
        $post = Post::find($id) ?? null;

        if($post) {
            $post->categories()->detach();
            
            $post->delete();

            return response()->json([
                'message' => "Succesfully deleted post!"
            ]);
        } else {
            return response()->json([
                'Error' => "Post not found"
            ], 404);
        }
    }
}
