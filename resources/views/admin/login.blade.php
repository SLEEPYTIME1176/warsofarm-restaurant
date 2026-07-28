<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Warso Restaurant</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f5f0eb;
        }

        /* Left side - Branding */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #3f2a20 0%, #6b3f2a 50%, #9c5638 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            top: -100px;
            left: -100px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
            bottom: -80px;
            right: -80px;
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 360px;
        }

        .brand-content h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .brand-content p {
            opacity: 0.85;
            font-size: 1.05rem;
            line-height: 1.6;
        }

        /* Right side - Form */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            background: #fffaf5;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
        }

        .login-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            color: #3f2a20;
            margin-bottom: 6px;
        }

        .login-card .subtitle {
            color: #8b7355;
            font-size: 0.95rem;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 13.5px;
            color: #3f2a20;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid #e8ddd0;
            border-radius: 12px;
            font-size: 15px;
            background: white;
            color: #3f2a20;
            transition: all 0.25s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #9c5638;
            box-shadow: 0 0 0 4px rgba(156, 86, 56, 0.12);
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #9c5638, #7d432c);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(156, 86, 56, 0.25);
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(156, 86, 56, 0.35);
        }

        .error-box {
            background: #fef2f2;
            color: #b91c1c;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 14px;
            margin-bottom: 20px;
            border: 1px solid #fecaca;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 28px;
            font-size: 14px;
            color: #8b7355;
            text-decoration: none;
        }

        .back-link:hover {
            color: #9c5638;
        }

        /* Mobile */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .login-left {
                padding: 50px 24px;
                min-height: 220px;
            }
            .brand-content h1 {
                font-size: 2rem;
            }
            .login-right {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Left Branding -->
    <div class="login-left">
        <div class="brand-content">
            <h1>Warso</h1>
            <p>Panel Admin Restoran<br>Kelola menu, pesanan, dan reservasi dengan mudah.</p>
        </div>
    </div>

    <!-- Right Form -->
    <div class="login-right">
        <div class="login-card">
            <h2>Selamat Datang</h2>
            <p class="subtitle">Masuk ke dashboard admin</p>

            @if($errors->any())
                <div class="error-box">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@warso.com" required autofocus>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>

                <button type="submit" class="btn-login">Masuk ke Dashboard</button>
            </form>

            <a href="/" class="back-link">← Kembali ke Website</a>
        </div>
    </div>
</body>
</html>