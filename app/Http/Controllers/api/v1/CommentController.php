<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'post_id' => 'required',
            'comment_description' => 'required'
        ]);

        Comment::create([
            'user_id' => $validated['user_id'],
            'post_id' => $validated['post_id'],
            'comment_description' => $validated['comment_description']
        ]);

        return response()->json([
            'message' => "Comment created successfully!"
        ], 201);
    }

    // Update the specified resource in storage.
    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id) ?? null;

        if($comment) {
            $validated = $request->validate(['comment_description' => 'required']);

            $comment->update([
                'comment_description' => $validated['comment_description']
            ]);

            return response()->json([
                'message' => "Comment updated successfully!"
            ]);
        } else {
            return response()->json([
                'error' => "Comment not found",
            ], 404); 
        }
        
    }

    // Remove the specified resource from storage.
    public function destroy(string $id)
    {
        $comment = Comment::find($id) ?? null;

        if($comment) {
            
            $comment->delete();

            return response()->json([
                'message' => 'Comment deleted successfully',
            ]);

        } else {
            return response()->json([
                'error' => "Comment not found",
            ], 404); 
        }
    }
}
