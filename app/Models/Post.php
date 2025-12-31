<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'author_id', 
        'status', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Scope for published posts
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Scope for draft posts
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Check if post is published
    public function isPublished()
    {
        return $this->status === 'published';
    }

    // Publish a post
    public function publish()
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    // Relationship with author
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}