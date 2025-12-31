<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // Verify post is published
        if (!$post->is_published) {
            return response()->json([
                'error' => 'Cannot comment on unpublished post'
            ], 403);
        }

        $validated = $request->validate([
            'user_name' => 'required|string|max:100',
            'user_email' => 'required|email|max:100',
            'content' => 'required|string|max:500'
        ]);

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_name' => $validated['user_name'],
            'user_email' => $validated['user_email'],
            'content' => $validated['content']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment submitted successfully',
            'data' => [
                'id' => $comment->id,
                'user_name' => $comment->user_name,
                'user_email' => $comment->user_email,
                'content' => $comment->content,
                'created_at' => $comment->created_at->format('Y-m-d H:i:s')
            ]
        ], 201);
    }
}