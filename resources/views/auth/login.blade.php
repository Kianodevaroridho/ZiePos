<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ZiePos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #312E81 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .login-container {
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.6s ease;
        }
        .login-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        }
        .brand-section {
            text-align: center;
            margin-bottom: 2rem;
        }
        .brand-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
            margin-bottom: 1rem;
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.4);
        }
        .brand-section h2 {
            font-weight: 800;
            color: #1E293B;
            font-size: 1.5rem;
        }
        .brand-section p {
            color: #64748B;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            color: #475569;
            margin-bottom: 0.35rem;
        }
        .form-control {
            border-radius: 12px;
            border: 1.5px solid #E2E8F0;
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }
        .btn-login {
            background: linear-gradient(135deg, #4F46E5, #6366F1);
            border: none;
            border-radius: 12px;
            padding: 0.75rem;
            font-weight: 700;
            font-size: 0.95rem;
            color: white;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #3730A3, #4F46E5);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.4);
            color: white;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="brand-section">
                <div class="brand-icon">
                    <i class="bi bi-shop"></i>
                </div>
                <h2>ZiePos</h2>
                <p>Masuk ke sistem kasir Anda</p>
            </div>

            @if($errors->any())
            <div class="alert alert-danger py-2 px-3" style="border-radius:10px; font-size:0.85rem;">
                <i class="bi bi-exclamation-circle me-1"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent" style="border-radius:12px 0 0 12px; border-right:0;"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" name="email" class="form-control" style="border-left:0;" placeholder="email@example.com" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent" style="border-radius:12px 0 0 12px; border-right:0;"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control" style="border-left:0;" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember" style="font-size:0.85rem;">Ingat saya</label>
                </div>
                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>
