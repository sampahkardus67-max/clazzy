<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Clazzy</title>
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
            padding: 2rem 0;
        }

        .register-container {
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
            background: linear-gradient(135deg, #0891b2 0%, #06b6d4 100%);
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

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        input[type="text"]:focus,
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

        .btn-register {
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

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(147, 51, 234, 0.3);
        }

        .btn-register:active {
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

        .login-link {
            text-align: center;
            color: #666;
        }

        .login-link a {
            color: #9333ea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .login-link a:hover {
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
            .register-container {
                padding: 2rem;
            }

            .logo-section h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo-section">
            <div class="logo-icon">C</div>
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

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

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

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Daftar
            </button>
        </form>

        <div class="divider">
            <span>Atau</span>
        </div>

        <div class="login-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>
</body>
</html>
