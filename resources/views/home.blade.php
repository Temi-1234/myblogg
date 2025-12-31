<!-- resources/views/home.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog - Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f9f9f9;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        header {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1.5rem 0;
            margin-bottom: 2rem;
        }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .blog-title {
            font-size: 2rem;
            color: #2c3e50;
            text-decoration: none;
        }
        nav a {
            margin-left: 1.5rem;
            color: #555;
            text-decoration: none;
            font-weight: 500;
        }
        nav a:hover {
            color: #3498db;
        }
        .admin-link {
            background: #3498db;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }
        main {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        .posts-container {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        .post {
            border-bottom: 1px solid #eee;
            padding: 1.5rem 0;
        }
        .post:last-child {
            border-bottom: none;
        }
        .post-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .post-title a {
            color: #2c3e50;
            text-decoration: none;
        }
        .post-meta {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .post-excerpt {
            color: #555;
            margin-bottom: 1rem;
        }
        .read-more {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
        .sidebar {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            height: fit-content;
        }
        .widget {
            margin-bottom: 2rem;
        }
        .widget h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #3498db;
        }
        .no-posts {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }
        footer {
            margin-top: 3rem;
            padding: 2rem 0;
            text-align: center;
            color: #7f8c8d;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <a href="/" class="blog-title">My Blog</a>
            <nav>
    <a href="/">Home</a>
    <a href="#">About</a>
    <a href="#">Contact</a>
    <!-- Admin link removed -->
</nav>
        </div>
    </header>

    <div class="container">
        <main>
            <div class="posts-container">
                @if($posts->count() > 0)
                    @foreach($posts as $post)
                        <article class="post">
                            <h2 class="post-title">
                                <a href="{{ route('home.post', $post->slug) }}">{{ $post->title }}</a>
                            </h2>
                            <div class="post-meta">
                                By {{ $post->author->name ?? 'Admin' }} • 
                                {{ $post->created_at->format('F j, Y') }} • 
                                {{ $post->status }}
                            </div>
                            <div class="post-excerpt">
                                {{ Str::limit($post->content, 200) }}
                            </div>
                            <a href="{{ route('home.post', $post->slug) }}" class="read-more">Read More →</a>
                        </article>
                    @endforeach
                @else
                    <div class="no-posts">
                        <h2>Welcome to My Blog! 👋</h2>
                        <p>No posts have been published yet. Check back soon for updates!</p>
                        <p><em>Note: Only published posts appear here. Drafts remain private.</em></p>
                        <p style="margin-top: 1rem;">
                            <a href="/admin/posts/create" class="admin-link">Create Your First Post</a>
                        </p>
                    </div>
                @endif
            </div>

            <aside class="sidebar">
                <div class="widget about-widget">
                    <h3>About This Blog</h3>
                    <p>Welcome to my personal blog where I share thoughts on various topics. Built with Laravel.</p>
                </div>

                <div class="widget stats-widget">
                    <h3>Blog Stats</h3>
                    <ul style="list-style: none; padding: 0;">
                        <li><strong>{{ $posts->count() }}</strong> Total Posts</li>
                        <li><strong>{{ $posts->where('status', 'published')->count() }}</strong> Published</li>
                        <li><strong>0</strong> Comments</li>
                    </ul>
                </div>

                <div class="widget recent-posts">
                    <h3>Recent Posts</h3>
                    @if($posts->count() > 0)
                        <ul style="list-style: none; padding: 0;">
                            @foreach($posts->take(3) as $post)
                                <li style="margin-bottom: 0.5rem;">
                                    <a href="{{ route('home.post', $post->slug) }}">{{ $post->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>No posts yet.</p>
                    @endif
                </div>
            </aside>
        </main>
    </div>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} My Blog. Built with Laravel.</p>
            <p>
                <a href="/admin/posts">Admin Dashboard</a> | 
                <a href="/login">Login</a>
            </p>
        </div>
    </footer>
</body>
</html>