<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clazzy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            padding: 3rem;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1rem;
        }

        .logo-section h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .logo-section p {
            color: #666;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #9333ea;
            box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
        }

        .error-message {
            color: #d32f2f;
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remember-me input {
            cursor: pointer;
        }

        .forgot-password {
            color: #9333ea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .forgot-password:hover {
            color: #a855f7;
        }

        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #9333ea 0%, #a855f7 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(147, 51, 234, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            color: #999;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-top: 1px solid #e0e0e0;
        }

        .divider span {
            padding: 0 1rem;
            font-size: 0.85rem;
        }

        .register-link {
            text-align: center;
            color: #666;
        }

        .register-link a {
            color: #9333ea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .register-link a:hover {
            color: #a855f7;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef5350;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #4caf50;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 2rem;
            }

            .logo-section h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
           <img src="https://sugenghartono.ac.id/wp-content/uploads/2024/03/cropped-LOGO-USH-NEW.png" alt="Logo" class="logo-icon">
            <h1>Clazzy</h1>
            <p>Aplikasi Akademik</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-footer">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
                <a href="#" class="forgot-password">Lupa password?</a>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>

    </div>
</body>
</html>
