 
@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Post Content -->
        <article class="card mb-4">
            <div class="card-body">
                <h1 class="card-title mb-3">{{ $post->title }}</h1>
                
                <div class="text-muted mb-4">
                    <small>
                        <i class="fas fa-user"></i> <strong>{{ $post->author->name }}</strong> | 
                        <i class="fas fa-calendar"></i> {{ $post->published_at->format('F d, Y') }} | 
                        <i class="fas fa-clock"></i> {{ $post->published_at->format('h:i A') }}
                    </small>
                </div>
                
                <div class="post-content mb-4">
                    {!! nl2br(e($post->content)) !!}
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                        ← Back to Posts
                    </a>
                    <div class="text-muted">
                        <small>
                            <i class="fas fa-eye"></i> Post #{{ $post->id }}
                        </small>
                    </div>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-comments"></i> Comments ({{ $post->comments->count() }})
                </h5>
            </div>
            
            <div class="card-body">
                <!-- Comments List -->
                @forelse($post->comments as $comment)
                    <div class="comment mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong class="d-block">{{ $comment->user_name }}</strong>
                                <small class="text-muted">{{ $comment->user_email }}</small>
                            </div>
                            <small class="text-muted">
                                {{ $comment->created_at->format('M d, Y H:i') }}
                            </small>
                        </div>
                        <p class="mb-0 mt-2">{{ $comment->content }}</p>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No comments yet. Be the first to comment!</p>
                    </div>
                @endforelse

                <!-- Add Comment Form -->
                <div class="mt-4 pt-3 border-top">
                    <h6 class="mb-3"><i class="fas fa-edit"></i> Add a Comment</h6>
                    <form id="commentForm">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Your Name *</label>
                                <input type="text" class="form-control" name="user_name" required 
                                       placeholder="Enter your name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address *</label>
                                <input type="email" class="form-control" name="user_email" required 
                                       placeholder="Enter your email">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Your Comment *</label>
                            <textarea class="form-control" name="content" rows="4" required 
                                      placeholder="Write your comment here..."></textarea>
                            <small class="text-muted">Maximum 500 characters</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Submit Comment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.getElementById('commentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    const button = form.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
    
    // Disable button
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
    
    try {
        const response = await fetch('/api/posts/{{ $post->id }}/comments', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            // Show success message
            alert('✅ Comment submitted successfully!');
            // Reload page to show new comment
            window.location.reload();
        } else {
            // Show error
            alert('❌ ' + (data.error || 'Failed to submit comment'));
            button.disabled = false;
            button.innerHTML = originalText;
        }
    } catch (error) {
        alert('❌ Network error. Please check your connection.');
        button.disabled = false;
        button.innerHTML = originalText;
    }
});

// Add Font Awesome
const faLink = document.createElement('link');
faLink.rel = 'stylesheet';
faLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
document.head.appendChild(faLink);
</script>

<style>
.post-content {
    line-height: 1.8;
    font-size: 1.1rem;
}
.post-content p {
    margin-bottom: 1.5rem;
}
.comment {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}
</style>
@endsection
@endsection