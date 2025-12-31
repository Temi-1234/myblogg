@extends('layouts.app')

@section('title', 'My Blog')

@section('content')
<div class="container">
    <div class="text-center mb-5">
        <h1 class="display-4">📝 My Blog</h1>
        <p class="lead">Welcome to my blog. Read the latest posts below.</p>
        @auth
            <a href="{{ url('/admin/posts') }}" class="btn btn-primary">Go to Admin Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-primary">Admin Login</a>
        @endauth
    </div>

    @if($posts->count() > 0)
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('home.post', $post->slug) }}" class="text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            <p class="card-text text-muted">
                                <small>
                                    By {{ $post->author->name }} • 
                                    {{ $post->created_at->format('F j, Y') }}
                                    @if(!$post->is_published)
                                        <span class="badge bg-warning ms-2">Draft</span>
                                    @endif
                                </small>
                            </p>
                            <p class="card-text">
                                {{ Str::limit(strip_tags($post->content), 150) }}
                            </p>
                            <a href="{{ route('home.post', $post->slug) }}" class="btn btn-outline-primary">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-file-alt fa-4x text-muted mb-4"></i>
            <h4 class="text-muted">No posts yet</h4>
            <p class="text-muted">Check back soon for new content!</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Add Font Awesome
    const faLink = document.createElement('link');
    faLink.rel = 'stylesheet';
    faLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
    document.head.appendChild(faLink);
</script>
@endsection