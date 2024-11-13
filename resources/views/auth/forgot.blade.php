<!DOCTYPE html>
<html>
<head>
    <title>PORTAL SIMAS - Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url(https://ppid.polinema.ac.id/wp-content/uploads/2024/02/GRAHA-POLINEMA1-slider-01.webp);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
            display: flex;
            flex-direction: column;
            /* Mengatur elemen secara vertikal */
            align-items: center;
            color: white;
            font-size: 1.2em;
            text-align: center;
        }

        .logo img {
            height: 60px;
            margin-bottom: 5px;
            /* Spasi antara gambar dan teks */
        }

        .logo-text {
            font-size: 1em;
            color: black;
        }

        .forgot-password-container {
            position: absolute;
            top: 50%;
            right: 10%;
            transform: translateY(-50%);
            width: 400px;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .form-label {
            color: #666;
            margin-bottom: 8px;
            font-size: 0.9em;
        }

        .btn-confirm {
            background: #2196F3;
            color: white;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            margin-top: 10px;
        }

        .btn-confirm:hover {
            background: #1976D2;
            color: white;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<body>
    <div class="logo">
        <img src="{{ asset('images/jti.png') }}" alt="Logo">
        <div class="logo-text">PORTAL SIMAS</div>
    </div>

    <div class="forgot-password-container">
        <h2 class="form-title">Forgot Password</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Enter your email address</label>
                <input type="email" class="form-control" name="email" placeholder="Email address" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Enter your Password</label>
                <input type="password" class="form-control" name="password" placeholder="New password" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Enter your Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password" required>
            </div>

            <button type="submit" class="btn btn-confirm">Confirm</button>
        </form>
    </div>
</body>
</html>