@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">🔐 Admin Login</h4>
            </div>
            
            <div class="card-body">
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" 
                               placeholder="admin@myblog.com" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="admin123" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Login as Admin</button>
                    </div>
                </form>
                
                <div class="mt-4 text-center">
                    <p class="text-muted mb-1">
                        <small>Default admin credentials:</small>
                    </p>
                    <p class="mb-0">
                        <code>admin@myblog.com</code> / <code>admin123</code>
                    </p>
                    <p class="text-muted mt-2">
                        <small>No public registration. Admin access only.</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection