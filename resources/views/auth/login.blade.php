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
            <svg class="login-illustration" viewBox="0 0 500 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="50" y="50" width="400" height="300" rx="20" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                <rect x="70" y="80" width="120" height="80" rx="10" fill="rgba(255,255,255,0.15)"/>
                <rect x="200" y="80" width="120" height="80" rx="10" fill="rgba(255,255,255,0.15)"/>
                <rect x="330" y="80" width="100" height="80" rx="10" fill="rgba(255,255,255,0.15)"/>
                <rect x="70" y="180" width="250" height="150" rx="10" fill="rgba(255,255,255,0.1)"/>
                <rect x="330" y="180" width="100" height="70" rx="10" fill="rgba(255,255,255,0.1)"/>
                <rect x="330" y="260" width="100" height="70" rx="10" fill="rgba(255,255,255,0.1)"/>
                <path d="M90 280 L130 250 L170 270 L210 220 L250 240 L290 200" stroke="rgba(255,255,255,0.5)" stroke-width="3" fill="none" stroke-linecap="round"/>
                <circle cx="90" cy="280" r="5" fill="white"/>
                <circle cx="130" cy="250" r="5" fill="white"/>
                <circle cx="170" cy="270" r="5" fill="white"/>
                <circle cx="210" cy="220" r="5" fill="white"/>
                <circle cx="250" cy="240" r="5" fill="white"/>
                <circle cx="290" cy="200" r="5" fill="white"/>
                <circle cx="130" cy="120" r="20" fill="rgba(255,255,255,0.2)"/>
                <circle cx="260" cy="120" r="20" fill="rgba(255,255,255,0.2)"/>
                <circle cx="380" cy="120" r="20" fill="rgba(255,255,255,0.2)"/>
                <circle cx="30" cy="150" r="15" fill="rgba(255,255,255,0.1)">
                    <animate attributeName="cy" values="150;130;150" dur="3s" repeatCount="indefinite"/>
                </circle>
                <circle cx="470" cy="250" r="20" fill="rgba(255,255,255,0.1)">
                    <animate attributeName="cy" values="250;270;250" dur="4s" repeatCount="indefinite"/>
                </circle>
            </svg>
            <h2>Selamat Datang di ALKAHFI DIGITAL</h2>
            <p>Sistem Pembayaran SPP Santri - Kelola pembayaran SPP dengan mudah, cepat, dan transparan.</p>
        </div>

        <div class="login-right">
            <div class="login-form">
                <div class="text-center mb-5">
                    <div class="sidebar-logo d-inline-flex mb-4" style="width: 60px; height: 60px; font-size: 28px;">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <h1>Masuk</h1>
                    <p class="subtitle">Silakan masukkan email dan password Anda.</p>
                </div>

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

                    <div class="d-flex justify-between align-center mb-4">
                        <label class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input">
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Masuk
                    </button>
                </form>

                <div class="text-center mt-5">
                    <button class="theme-toggle" id="themeToggle" style="background: var(--border-color);">
                        <i class="bi bi-moon-fill"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .login-page { display: flex; min-height: 100vh; }
        .login-left { flex: 1; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px; color: white; }
        .login-left h2 { font-size: 2rem; margin-top: 40px; margin-bottom: 16px; }
        .login-left p { opacity: 0.9; text-align: center; max-width: 400px; }
        .login-illustration { width: 100%; max-width: 400px; }
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

        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        updateIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            const icon = themeToggle.querySelector('i');
            icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
        }
    </script>
</body>
</html>
