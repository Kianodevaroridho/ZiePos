<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ZiePos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background-color: #F8FAFC;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .register-card {
            background-color: #FFFFFF;
            border-radius: 24px;
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
            animation: fadeIn 0.5s ease-out;
        }
        .brand-badge {
            width: 72px;
            height: 72px;
            background-color: #0F172A;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem auto;
            box-shadow: 0 8px 16px rgba(15, 23, 42, 0.15);
        }
        .brand-title {
            font-weight: 700;
            color: #0F172A;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 0.25rem;
        }
        .brand-subtitle {
            color: #64748B;
            font-size: 0.95rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #0F172A;
            margin-bottom: 0.5rem;
        }
        .input-group-custom {
            position: relative;
            margin-bottom: 1.25rem;
        }
        .input-group-custom i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            font-size: 1.15rem;
            z-index: 10;
        }
        .input-group-custom .form-control {
            background-color: #F8FAFC;
            border: 1.5px solid #E2E8F0;
            border-radius: 12px;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            font-size: 0.95rem;
            height: 50px;
            color: #0F172A;
            transition: all 0.2s ease-in-out;
        }
        .input-group-custom .form-control::placeholder {
            color: #94A3B8;
        }
        .input-group-custom .form-control:focus {
            background-color: #FFFFFF;
            border-color: #0F172A;
            box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.08);
            outline: none;
        }
        .btn-submit {
            background-color: #0F172A;
            color: #FFFFFF;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            height: 50px;
            width: 100%;
            transition: all 0.2s ease-in-out;
            margin-top: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .btn-submit:hover {
            background-color: #1E293B;
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }
        .btn-submit:active {
            transform: translateY(0);
        }
        .footer-text {
            text-align: center;
            font-size: 0.9rem;
            color: #64748B;
            margin-bottom: 0;
        }
        .login-link {
            color: #0F172A;
            font-weight: 700;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="brand-badge">
            <i class="bi bi-shop text-white" style="font-size: 1.75rem;"></i>
        </div>
        <h3 class="brand-title">Daftar Akun</h3>
        <p class="brand-subtitle">Buat akun baru ZiePos</p>

        @if($errors->any())
        <div class="alert alert-danger border-0 mb-3 py-2.5 px-3" style="border-radius: 12px; font-size: 0.85rem; background-color: #FEF2F2; color: #991B1B;">
            <i class="bi bi-exclamation-circle-fill me-2" style="color: #EF4444;"></i>
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-group-custom">
                    <i class="bi bi-person"></i>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group-custom">
                    <i class="bi bi-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group-custom">
                    <i class="bi bi-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <div class="input-group-custom">
                    <i class="bi bi-shield-lock"></i>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password" required>
                </div>
            </div>
            <button type="submit" class="btn-submit">
                Daftar
            </button>
            <p class="footer-text">
                Sudah punya akun? <a href="{{ route('login') }}" class="login-link">Masuk</a>
            </p>
        </form>
    </div>
</body>
</html>
