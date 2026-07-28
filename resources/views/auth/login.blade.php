<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Warso Restaurant</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f0eb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 420px;
        }
        h1 { font-size: 24px; margin-bottom: 8px; color: #3f2a20; }
        p { color: #888; margin-bottom: 30px; }
        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 14px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 12px;
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.2s;
        }
        .btn-google:hover {
            background: #f8f8f8;
            border-color: #ccc;
        }
        .divider {
            text-align: center;
            margin: 24px 0;
            color: #aaa;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Login</h1>
        <p>Masuk ke akun Warso Restaurant</p>

        <a href="{{ route('google.login') }}" class="btn-google">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" height="20" alt="Google">
            Login dengan Google
        </a>

        <div class="divider">atau</div>

        <p style="text-align:center; font-size:14px; color:#666;">
            <a href="/" style="color:#9c5638;">Kembali ke Beranda</a>
        </p>
    </div>
</body>
</html>