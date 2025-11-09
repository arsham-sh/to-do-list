<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimal Login Form</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2>Login</h2>
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
            
            <form class="login-form" id="loginForm" method="POST" action="{{ route('login.store') }}">
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

                <button type="submit" class="login-btn">
                    <span class="btn-text">Login</span>
                </button>
            </form>

            <div class="signup-link">
                <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>