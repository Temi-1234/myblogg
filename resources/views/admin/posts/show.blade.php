<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - My Blog</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, sans-serif; line-height: 1.6; color: #333; background: #f9f9f9; }
        .container { max-width: 800px; margin: 0 auto; padding: 0 20px; }
        header { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 1.5rem 0; margin-bottom: 2rem; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .blog-title { font-size: 2rem; color: #2c3e50; text-decoration: none; }
        nav a { margin-left: 1.5rem; color: #555; text-decoration: none; }
        .post-content { background: white; border-radius: 8px; padding: 3rem; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
        .post-header { margin-bottom: 2rem; }
        .post-title { font-size: 2.5rem; color: #2c3e50; margin-bottom: 1rem; }
        .post-meta { color: #7f8c8d; font-size: 1rem; margin-bottom: 1rem; }
        .post-body { font-size: 1.1rem; line-height: 1.8; }
        .post-body p { margin-bottom: 1.5rem; }
        footer { margin-top: 3rem; padding: 2rem 0; text-align: center; color: #7f8c8d; border-top: 1px solid #eee; }
        .admin-badge { 
            display: inline-block; 
            background: #f0f0f0; 
            color: #666; 
            padding: 0.2rem 0.5rem; 
            border-radius: 4px; 
            font-size: 0.8rem; 
            margin-left: 0.5rem; 
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <a href="/" class="blog-title">My Blog</a>
            <nav>
                <a href="/">← Back to Home</a>
                @auth
                    <a href="/admin/posts">Admin</a>
                @endauth
            </nav>
        </div>
    </header>

    <div class="container">
        <article class="post-content">
            <div class="post-header">
                <h1 class="post-title">{{ $post->title }}</h1>
                <div class="post-meta">
                    By {{ $post->author->name ?? 'Admin' }} • 
                    @if($post->published_at)
                        Published on {{ $post->published_at->format('F j, Y') }}
                    @else
                        {{ $post->created_at->format('F j, Y') }}
                    @endif
                    
                    <!-- Show status badge only to admin users -->
                    @auth
                        <span class="admin-badge">
                            {{ ucfirst($post->status) }}
                        </span>
                    @endauth
                </div>
            </div>
            
            <div class="post-body">
                {!! nl2br(e($post->content)) !!}
            </div>
            
            <!-- Edit link for admin -->
            @auth
                <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #eee;">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="btn" 
                       style="background: #f0f0f0; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
                        ✏️ Edit this post
                    </a>
                </div>
            @endauth
        </article>
    </div>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} My Blog</p>
            <p><a href="/">Home</a> | <a href="/login">Admin Login</a></p>
        </div>
    </footer>
</body>
</html>