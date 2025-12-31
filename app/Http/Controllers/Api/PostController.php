<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->with('author')
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'excerpt' => Str::limit(strip_tags($post->content), 150),
                    'author' => $post->author->name,
                    'published_at' => $post->published_at->format('Y-m-d H:i:s'),
                    'comment_count' => $post->comments->count()
                ];
            });

        return response()->json([
            'success' => true,
            'count' => $posts->count(),
            'data' => $posts
        ]);
    }

    public function show($slug)
    {
        $post = Post::published()
            ->with(['author', 'comments'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'author' => $post->author->name,
                'published_at' => $post->published_at->format('Y-m-d H:i:s'),
                'comments' => $post->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'user_name' => $comment->user_name,
                        'user_email' => $comment->user_email,
                        'content' => $comment->content,
                        'created_at' => $comment->created_at->format('Y-m-d H:i:s')
                    ];
                })
            ]
        ]);
    }
}