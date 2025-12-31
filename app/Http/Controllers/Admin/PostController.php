<?php

namespace App\Http\Controllers\Admin; // Make sure this is correct

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // This line is crucial - with correct namespace

class PostController extends Controller
{
    // Show all posts
    public function index()
    {
        $posts = Post::with('author')->latest()->paginate(10);
        
        // Add statistics for the cards
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        $draftPosts = Post::where('status', 'draft')->count();
        $totalComments = 0;
        
        return view('admin.posts.index', compact(
            'posts', 
            'totalPosts', 
            'publishedPosts', 
            'draftPosts', 
            'totalComments'
        ));
    }

    // Show create form
    public function create()
    {
        return view('admin.posts.create');
    }

    // Store new post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);
        
        // Generate unique slug
        $slug = Str::slug($validated['title']); // This uses Illuminate\Support\Str
        $originalSlug = $slug;
        $counter = 1;
        
        // Check if slug already exists
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'slug' => $slug,
            'status' => $validated['status'],
            'author_id' => auth()->id(),
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);
        
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully!');
    }

    // Show single post
    public function show($id)
    {
        $post = Post::with(['author', 'comments'])->findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    // Show edit form
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    // Update post
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published',
        ]);
        
        // Generate slug only if title changed
        if ($post->title !== $validated['title']) {
            $slug = Str::slug($validated['title']); // This uses Illuminate\Support\Str
            $originalSlug = $slug;
            $counter = 1;
            
            // Check if slug already exists (excluding current post)
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $post->slug = $slug;
        }
        
        $updateData = [
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => $validated['status'],
        ];
        
        // Update published_at if status changed to published
        if ($validated['status'] === 'published' && $post->status !== 'published') {
            $updateData['published_at'] = now();
        }
        
        $post->update($updateData);
        
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    // Delete post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        
        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully!');
    }
}