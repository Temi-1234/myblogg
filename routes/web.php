<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;

// Home Page
// Home Page - get only published posts
Route::get('/', function() {
    $posts = \App\Models\Post::with('author')
                ->where('status', 'published')
                ->latest()
                ->take(5)
                ->get();
    return view('home', compact('posts'));
})->name('home');
// Single Post - only accessible if published
Route::get('/post/{slug}', function($slug) {
    $post = \App\Models\Post::where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();
    return view('post.show', compact('post'));
})->name('home.post');

// Login Page
Route::get('/login', function() {
    return view('admin.login');
})->name('login');

// Login Process
Route::post('/login', function(\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/posts');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
})->name('login.post');

// Logout
Route::post('/logout', function(\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Admin Routes (protected)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Posts CRUD (complete routes)
    Route::get('/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
    Route::get('/posts/create', [AdminPostController::class, 'create'])->name('admin.posts.create');
    Route::post('/posts', [AdminPostController::class, 'store'])->name('admin.posts.store');
    Route::get('/posts/{post}', [AdminPostController::class, 'show'])->name('admin.posts.show');
    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');
});