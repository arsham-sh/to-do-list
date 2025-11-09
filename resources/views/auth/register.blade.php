<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimal Register Form</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Register</h2>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <form class="login-form" id="registerForm" method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                        <label for="username">Username</label>
                        @error('username')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" required>
                        <label for="password">Password</label>
                        @error('password')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                        <label for="password_confirmation">Confirm Password</label>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <span class="btn-text">Register</span>
                </button>
            </form>

            <div class="signup-link">
                <p>Have an account? <a href="{{ route('login') }}">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>