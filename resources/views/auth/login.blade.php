<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="login-page">
        <div class="login-left">
            <div class="login-overlay"></div>
            <div class="login-left-content">
                <h2>Selamat Datang di ALKAHFI DIGITAL</h2>
                <p>Sistem Pembayaran SPP Santri - Kelola pembayaran SPP dengan mudah, cepat, dan transparan.</p>
            </div>
        </div>

        <div class="login-right">
            <div class="login-form">
                <div class="text-center mb-5">
                    <img src="{{ asset('logo-alkahfi.png') }}" alt="Logo Al-Kahfi" class="login-logo mb-4">
                    <h1>Masuk</h1>
                    <p class="subtitle">Silakan masukkan email dan password Anda.</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="position-relative">
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" value="{{ old('email') }}" style="padding-left: 48px;" required>
                            <i class="bi bi-envelope position-absolute" style="left: 16px; top: 50%; transform: translateY(-50%); color: var(--secondary-color);"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="position-relative">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" style="padding-left: 48px; padding-right: 48px;" required>
                            <i class="bi bi-lock position-absolute" style="left: 16px; top: 50%; transform: translateY(-50%); color: var(--secondary-color);"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                   

                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-4">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Masuk
                    </button>
                     <div class="text-end mb-4">
                        <a href="{{ route('password.request') }}" class="text-link">Lupa password?</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <style>
        .login-page { display: flex; min-height: 100vh; }
        .login-left { flex: 1; background: url('{{ asset('loginbg.jpg') }}') center/cover no-repeat; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px; color: white; position: relative; }
        .login-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(79, 70, 229, 0.6) 0%, rgba(124, 58, 237, 0.6) 100%); }
        .login-left-content { position: relative; z-index: 1; text-align: center; max-width: 480px; }
        .login-left h2 { font-size: 2.5rem; margin-bottom: 20px; font-weight: 700; line-height: 1.2; text-shadow: 0 2px 10px rgba(0,0,0,0.2); }
        .login-left p { opacity: 0.95; text-align: center; font-size: 1.125rem; line-height: 1.7; text-shadow: 0 1px 4px rgba(0,0,0,0.15); }
        .login-right { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; background: var(--bg-card); }
        .login-form { width: 100%; max-width: 400px; }
        .login-form h1 { font-size: 1.75rem; margin-bottom: 8px; color: var(--text-main); }
        .login-form .subtitle { color: var(--text-muted); }
        .password-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; }
        .btn-lg { padding: 14px 24px; font-size: 1rem; }
        .text-center { text-align: center; }
        .mb-4 { margin-bottom: 24px; }
        .mb-5 { margin-bottom: 32px; }
        .mt-5 { margin-top: 32px; }
        .d-inline-flex { display: inline-flex; align-items: center; justify-content: center; background: var(--primary-subtle); border-radius: 12px; color: var(--primary-color); }
        .login-logo { width: 80px; height: 80px; object-fit: contain; }
        .text-end { text-align: right; }
        .text-link { color: var(--primary-color); text-decoration: none; font-size: 0.875rem; font-weight: 500; }
        .text-link:hover { text-decoration: underline; }
        @media (max-width: 768px) { .login-left { display: none; } .login-right { padding: 20px; } }
    </style>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
