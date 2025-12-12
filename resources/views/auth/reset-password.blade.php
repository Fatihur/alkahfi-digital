<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="login-page">
        <div class="login-left">
            <div class="login-overlay"></div>
            <div class="login-left-content">
                <h2>Reset Password</h2>
                <p>Buat password baru untuk akun Anda. Pastikan password mudah diingat namun sulit ditebak.</p>
            </div>
        </div>

        <div class="login-right">
            <div class="login-form">
                <div class="text-center mb-5">
                    <img src="{{ asset('logo-alkahfi.png') }}" alt="Logo Al-Kahfi" class="login-logo mb-4">
                    <h1>Reset Password</h1>
                    <p class="subtitle">Masukkan password baru Anda.</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="position-relative">
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" value="{{ $email ?? old('email') }}" style="padding-left: 48px;" required>
                            <i class="bi bi-envelope position-absolute" style="left: 16px; top: 50%; transform: translateY(-50%); color: var(--secondary-color);"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <div class="position-relative">
                            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password baru" style="padding-left: 48px; padding-right: 48px;" required>
                            <i class="bi bi-lock position-absolute" style="left: 16px; top: 50%; transform: translateY(-50%); color: var(--secondary-color);"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword('password', 'toggleIcon1')">
                                <i class="bi bi-eye" id="toggleIcon1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="position-relative">
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi password baru" style="padding-left: 48px; padding-right: 48px;" required>
                            <i class="bi bi-lock position-absolute" style="left: 16px; top: 50%; transform: translateY(-50%); color: var(--secondary-color);"></i>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'toggleIcon2')">
                                <i class="bi bi-eye" id="toggleIcon2"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-check-lg"></i>
                        Reset Password
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-link">
                        <i class="bi bi-arrow-left"></i> Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .login-page { display: flex; min-height: 100vh; }
        .login-left { flex: 1; background: url('{{ asset('login.jpg') }}') center/cover no-repeat; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px; color: white; position: relative; }
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
        .mt-4 { margin-top: 24px; }
        .login-logo { width: 80px; height: 80px; object-fit: contain; }
        .text-link { color: var(--primary-color); text-decoration: none; font-weight: 500; }
        .text-link:hover { text-decoration: underline; }
        @media (max-width: 768px) { .login-left { display: none; } .login-right { padding: 20px; } }
    </style>

    <script>
        function togglePassword(inputId, iconId) {
            const password = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
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
