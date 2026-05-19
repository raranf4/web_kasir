<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SweetBakery</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background: linear-gradient(rgba(92, 61, 46, 0.8), rgba(134, 84, 57, 0.8)), 
                        url('https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=1000') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.96);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .header-logo {
            font-size: 28px;
            font-weight: bold;
            color: #5c3d2e;
            margin-bottom: 5px;
        }
        .header-subtitle {
            font-size: 14px;
            color: #777;
            margin-bottom: 30px;
        }
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #5c3d2e;
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1d3cd;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }
        .form-control:focus {
            border-color: #865439;
            box-shadow: 0 0 8px rgba(134, 84, 57, 0.2);
        }
        .btn-bakery {
            background-color: #5c3d2e;
            color: white;
            border: none;
            width: 100%;
            padding: 14px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(92, 61, 46, 0.3);
        }
        .btn-bakery:hover {
            background-color: #3d281e;
        }
        .error-message {
            color: #d9534f;
            font-size: 13px;
            margin-top: 5px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="header-logo">🥐 SweetBakery</div>
        <div class="header-subtitle">Aplikasi Manajemen Stok & Kasir</div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="nama@bakery.com" required>
                @error('email') 
                    <div class="error-message">⚠️ {{ $message }}</div> 
                @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-bakery">Masuk ke Sistem</button>
        </form>
    </div>

</body>
</html>