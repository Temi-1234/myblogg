<!-- resources/views/admin/posts/index.blade.php -->
@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Statistics Cards Row -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Total Posts</h6>
                                    <h2 class="mb-0">{{ $totalPosts }}</h2>
                                </div>
                                <i class="fas fa-newspaper fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Published</h6>
                                    <h2 class="mb-0">{{ $publishedPosts }}</h2>
                                </div>
                                <i class="fas fa-check-circle fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Drafts</h6>
                                    <h2 class="mb-0">{{ $draftPosts }}</h2>
                                </div>
                                <i class="fas fa-edit fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title">Comments</h6>
                                    <h2 class="mb-0">{{ $totalComments }}</h2>
                                </div>
                                <i class="fas fa-comments fa-3x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Statistics Cards -->
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">📝 All Posts</h4>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Post
                    </a>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                            <tr>
                                <td>#{{ $post->id }}</td>
                                <td>{{ Str::limit($post->title, 50) }}</td>
                                <td>{{ $post->author->name ?? 'Admin' }}</td>
                                <td>
                                    @if($post->status == 'published')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Published
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-edit"></i> Draft
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.posts.show', $post) }}" 
                                           class="btn btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.posts.edit', $post) }}" 
                                           class="btn btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" 
                                                    onclick="return confirm('Delete this post?')" 
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No posts found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection