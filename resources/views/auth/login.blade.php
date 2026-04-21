{{-- ===================================================== --}}
{{-- FILE: login.blade.php --}}
{{-- DESKRIPSI: Halaman login untuk semua user (admin, bendahara, wali) --}}
{{--          Layout standalone (tidak extends layout utama) --}}
{{-- LOKASI: resources/views/auth/login.blade.php --}}
{{-- CONTROLLER: Auth/LoginController.php --}}
{{-- ROUTE: GET /login --}}
{{-- ===================================================== --}}

<!DOCTYPE html>
{{-- data-theme untuk dark/light mode --}}
<html lang="id" data-theme="light">
<head>
    {{-- Metadata --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Title dengan nama aplikasi dari config --}}
    <title>Login - {{ config('app.name') }}</title>
    
    {{-- Google Fonts - Inter dengan variasi weight lengkap --}}
    {{-- weights: 300(light), 400(regular), 500, 600, 700, 800(extra-bold) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    {{-- CSS Custom aplikasi --}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
    {{-- ===================================================== --}}
    {{-- CONTAINER UTAMA LOGIN PAGE --}}
    {{-- ===================================================== --}}
    {{-- login-page: Flex container full height --}}
    <div class="login-page">
        
        {{-- ---------------------------------------------------- --}}
        {{-- KIRI: Hero Section dengan Background --}}
        {{-- ---------------------------------------------------- --}}
        {{-- login-left: Bagian kiri dengan gambar background --}}
        {{-- flex: 1: Mengambil 50% lebar --}}
        {{-- CONTOH MODIFIKASI BACKGROUND: --}}
        {{-- style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" --}}
        <div class="login-left">
            {{-- Overlay gelap di atas background untuk kontras teks --}}
            {{-- gradient: Ungu ke ungu tua dengan opacity 60% --}}
            <div class="login-overlay"></div>
            
            {{-- Konten teks di atas overlay --}}
            <div class="login-left-content">
                {{-- Judul welcome --}}
                <h2>Selamat Datang di ALKAHFI DIGITAL</h2>
                {{-- Deskripsi aplikasi --}}
                <p>Sistem Pembayaran SPP Santri - Kelola pembayaran SPP dengan mudah, cepat, dan transparan.</p>
            </div>
        </div>

        {{-- ---------------------------------------------------- --}}
        {{-- KANAN: Form Login --}}
        {{-- ---------------------------------------------------- --}}
        {{-- login-right: Bagian kanan dengan form --}}
        <div class="login-right">
            {{-- login-form: Container form dengan max-width --}}
            <div class="login-form">
                
                {{-- Header Form --}}
                {{-- text-center: Teks di tengah --}}
                {{-- mb-5: Margin bottom besar (32px) --}}
                <div class="text-center mb-5">
                    {{-- Logo aplikasi --}}
                    {{-- CONTOH MODIFIKASI UKURAN LOGO: --}}
                    {{-- style="width: 120px; height: 120px;" --}}
                    <img src="{{ asset('logo-alkahfi.png') }}" alt="Logo Al-Kahfi" class="login-logo mb-4">
                    <h1>Masuk</h1>
                    {{-- subtitle: Keterangan bawah judul --}}
                    <p class="subtitle">Silakan masukkan email dan password Anda.</p>
                </div>

                {{-- Flash Message: Notifikasi sukses --}}
                {{-- Muncul setelah reset password berhasil --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Flash Message: Error validasi --}}
                {{-- $errors->any(): Cek apakah ada error --}}
                {{-- $errors->first(): Ambil pesan error pertama --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-circle"></i>
                        {{-- Tampilkan pesan error pertama --}}
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- ================================================= --}}
                {{-- FORM LOGIN --}}
                {{-- ================================================= --}}
                {{-- action="{{ route('login') }}": Submit ke POST /login --}}
                {{-- method="POST": HTTP method POST --}}
                <form action="{{ route('login') }}" method="POST">
                    {{-- @csrf: Token keamanan wajib untuk form POST --}}
                    @csrf
                    
                    {{-- Input Email --}}
                    {{-- form-group: Container untuk label dan input --}}
                    <div class="form-group">
                        {{-- form-label: Styling label --}}
                        <label class="form-label">Email</label>
                        {{-- position-relative: Untuk positioning icon --}}
                        <div class="position-relative">
                            {{-- Input email --}}
                            {{-- type="email": Validasi format email otomatis --}}
                            {{-- name="email": Nama field untuk controller --}}
                            {{-- value="{{ old('email') }}": Pertahankan nilai lama jika error --}}
                            {{-- required: Wajib diisi (validasi HTML5) --}}
                            {{-- style="padding-left: 48px;": Ruang untuk icon --}}
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" value="{{ old('email') }}" style="padding-left: 48px;" required>
                            {{-- Icon envelope di kiri input --}}
                            {{-- position-absolute: Posisi absolute dalam relative parent --}}
                            {{-- left: 16px; top: 50%; transform: translateY(-50%): Center vertikal --}}
                            {{-- CONTOH MODIFIKASI WARNA ICON: --}}
                            {{-- style="... color: #4f46e5;" untuk warna ungu --}}
                            <i class="bi bi-envelope position-absolute" style="left: 16px; top: 50%; transform: translateY(-50%); color: var(--secondary-color);"></i>
                        </div>
                    </div>

                    {{-- Input Password --}}
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="position-relative">
                            {{-- Input password --}}
                            {{-- id="password": Untuk diakses JavaScript toggle --}}
                            {{-- style padding-left dan padding-right: Ruang untuk icon kiri dan tombol kanan --}}
                            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" style="padding-left: 48px; padding-right: 48px;" required>
                            {{-- Icon lock di kiri input --}}
                            <i class="bi bi-lock position-absolute" style="left: 16px; top: 50%; transform: translateY(-50%); color: var(--secondary-color);"></i>
                            {{-- Tombol toggle show/hide password --}}
                            {{-- type="button": Agar tidak submit form --}}
                            {{-- onclick="togglePassword()": Panggil fungsi JavaScript --}}
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                {{-- Icon eye (mata) --}}
                                {{-- id="toggleIcon": Untuk diubah oleh JavaScript --}}
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Tombol Submit Login --}}
                    {{-- btn: Base class tombol --}}
                    {{-- btn-primary: Warna tema utama (biru/ungu) --}}
                    {{-- btn-lg: Ukuran besar --}}
                    {{-- w-100: Lebar 100% --}}
                    {{-- mb-4: Margin bottom --}}
                    {{-- CONTOH MODIFIKASI: --}}
                    {{-- style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;" --}}
                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-4">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Masuk
                    </button>
                    
                    {{-- Link Lupa Password --}}
                    {{-- text-end: Align teks ke kanan --}}
                    {{-- mb-4: Margin bottom --}}
                    <div class="text-end mb-4">
                        {{-- route('password.request'): Ke halaman forgot password --}}
                        {{-- text-link: Styling link tanpa underline --}}
                        <a href="{{ route('password.request') }}" class="text-link">Lupa password?</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- ===================================================== --}}
    {{-- INTERNAL CSS - Styling Spesifik Halaman Login --}}
    {{-- ===================================================== --}}
    <style>
        {{-- Layout dasar --}}
        .login-page { display: flex; min-height: 100vh; }
        
        {{-- Bagian kiri dengan background --}}
        .login-left { 
            flex: 1; 
            {{-- Background image dari folder public --}}
            background: url('{{ asset('loginbg.jpg') }}') center/cover no-repeat; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            padding: 40px; 
            color: white; 
            position: relative; 
        }
        
        {{-- Overlay gradient --}}
        .login-overlay { 
            position: absolute; 
            inset: 0; 
            {{-- Gradient ungu dengan opacity 60% --}}
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.6) 0%, rgba(124, 58, 237, 0.6) 100%); 
        }
        
        {{-- Konten kiri di atas overlay --}}
        .login-left-content { 
            position: relative; 
            z-index: 1; 
            text-align: center; 
            max-width: 480px; 
        }
        
        {{-- Judul halaman kiri --}}
        .login-left h2 { 
            font-size: 2.5rem; 
            margin-bottom: 20px; 
            font-weight: 700; 
            line-height: 1.2; 
            {{-- Shadow untuk kontras --}}
            text-shadow: 0 2px 10px rgba(0,0,0,0.2); 
        }
        
        {{-- Deskripsi halaman kiri --}}
        .login-left p { 
            opacity: 0.95; 
            text-align: center; 
            font-size: 1.125rem; 
            line-height: 1.7; 
            text-shadow: 0 1px 4px rgba(0,0,0,0.15); 
        }
        
        {{-- Bagian kanan form --}}
        .login-right { 
            flex: 1; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 40px; 
            background: var(--bg-card); 
        }
        
        {{-- Container form dengan batas lebar --}}
        .login-form { 
            width: 100%; 
            max-width: 400px; 
        }
        
        {{-- Judul form --}}
        .login-form h1 { 
            font-size: 1.75rem; 
            margin-bottom: 8px; 
            color: var(--text-main); 
        }
        
        {{-- Subtitle form --}}
        .login-form .subtitle { 
            color: var(--text-muted); 
        }
        
        {{-- Tombol toggle password --}}
        .password-toggle { 
            position: absolute; 
            right: 12px; 
            top: 50%; 
            transform: translateY(-50%); 
            background: none; 
            border: none; 
            color: var(--text-muted); 
            cursor: pointer; 
        }
        
        {{-- Utility classes --}}
        .btn-lg { padding: 14px 24px; font-size: 1rem; }
        .text-center { text-align: center; }
        .mb-4 { margin-bottom: 24px; }
        .mb-5 { margin-bottom: 32px; }
        .mt-5 { margin-top: 32px; }
        .d-inline-flex { display: inline-flex; align-items: center; justify-content: center; background: var(--primary-subtle); border-radius: 12px; color: var(--primary-color); }
        
        {{-- Logo styling --}}
        .login-logo { width: 80px; height: 80px; object-fit: contain; }
        
        {{-- Link styling --}}
        .text-end { text-align: right; }
        .text-link { color: var(--primary-color); text-decoration: none; font-size: 0.875rem; font-weight: 500; }
        .text-link:hover { text-decoration: underline; }
        
        {{-- Responsive: Mobile --}}
        {{-- Pada layar kecil, sembunyikan bagian kiri --}}
        @media (max-width: 768px) { 
            .login-left { display: none; } 
            .login-right { padding: 20px; } 
        }
    </style>

    {{-- ===================================================== --}}
    {{-- JAVASCRIPT - Toggle Show/Hide Password --}}
    {{-- ===================================================== --}}
    <script>
        /**
         * Fungsi togglePassword()
         * 
         * Mengubah type input password antara 'password' dan 'text'
         * serta mengganti icon eye / eye-slash
         */
        function togglePassword() {
            // Ambil elemen input password
            const password = document.getElementById('password');
            // Ambil elemen icon
            const icon = document.getElementById('toggleIcon');
            
            // Cek type input saat ini
            if (password.type === 'password') {
                // Ubah ke text (tampilkan password)
                password.type = 'text';
                // Ganti icon ke eye-slash (mata tertutup)
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                // Ubah ke password (sembunyikan password)
                password.type = 'password';
                // Ganti icon ke eye (mata terbuka)
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
