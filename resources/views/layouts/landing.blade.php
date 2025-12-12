<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>@yield('title', $profil->nama_sekolah ?? 'Sekolah')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    @if($profil && $profil->logo)
        <link href="{{ Storage::url($profil->logo) }}" rel="icon">
    @else
        <link href="{{ asset('logo-alkahfi.png') }}" rel="icon">
    @endif

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('landing/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('landing/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('landing/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('landing/css/style.css') }}" rel="stylesheet">

    <!-- Trix Content Styles -->
    <style>
        .trix-content h1 { font-size: 1.5rem; font-weight: 700; margin: 1rem 0; }
        .trix-content h2 { font-size: 1.25rem; font-weight: 600; margin: 1rem 0; }
        .trix-content ul, .trix-content ol { margin: 1rem 0; padding-left: 2rem; }
        .trix-content li { margin-bottom: 0.5rem; }
        .trix-content blockquote { border-left: 4px solid #06BBCC; padding-left: 1rem; margin: 1rem 0; font-style: italic; color: #666; }
        .trix-content a { color: #06BBCC; }
        .trix-content strong { font-weight: 700; }
        .trix-content p { margin-bottom: 1rem; }
        
        /* Hero Slider Styles */
        .owl-carousel-item {
            height: 600px;
            overflow: hidden;
        }
        
        .owl-carousel-item img {
            width: 100%;
            height: 600px;
            object-fit: cover;
            object-position: center;
        }
        
        /* Responsive Slider */
        @media (max-width: 768px) {
            .owl-carousel-item {
                height: 400px;
            }
            
            .owl-carousel-item img {
                height: 400px;
            }
        }
        
        @media (max-width: 576px) {
            .owl-carousel-item {
                height: 300px;
            }
            
            .owl-carousel-item img {
                height: 300px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="{{ route('landing.index') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            @if($profil && $profil->logo)
                <img src="{{ Storage::url($profil->logo) }}" alt="Logo" height="40" class="me-2">
            @else
                <img src="{{ asset('logo-alkahfi.png') }}" alt="Logo" height="40" class="me-2">
            @endif
            <h2 class="m-0 text-primary" style="font-size: 1.2rem;">{{ $profil->nama_sekolah ?? 'Sekolah' }}</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ route('landing.index') }}" class="nav-item nav-link {{ request()->routeIs('landing.index') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('landing.profil') }}" class="nav-item nav-link {{ request()->routeIs('landing.profil') ? 'active' : '' }}">Profil</a>
                <a href="{{ route('landing.berita') }}" class="nav-item nav-link {{ request()->routeIs('landing.berita*') ? 'active' : '' }}">Berita</a>
                <a href="{{ route('landing.galeri') }}" class="nav-item nav-link {{ request()->routeIs('landing.galeri') ? 'active' : '' }}">Galeri</a>
                <a href="{{ route('landing.kontak') }}" class="nav-item nav-link {{ request()->routeIs('landing.kontak') ? 'active' : '' }}">Kontak</a>
            </div>
            <a href="{{ route('login') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Menu</h4>
                    <a class="btn btn-link" href="{{ route('landing.index') }}">Beranda</a>
                    <a class="btn btn-link" href="{{ route('landing.profil') }}">Profil Sekolah</a>
                    <a class="btn btn-link" href="{{ route('landing.berita') }}">Berita</a>
                    <a class="btn btn-link" href="{{ route('landing.galeri') }}">Galeri</a>
                    <a class="btn btn-link" href="{{ route('landing.kontak') }}">Kontak</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Kontak</h4>
                    @if($profil->alamat ?? false)
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>{{ $profil->alamat }}</p>
                    @endif
                    @if($profil->telepon ?? false)
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>{{ $profil->telepon }}</p>
                    @endif
                    @if($profil->email ?? false)
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>{{ $profil->email }}</p>
                    @endif
                    @if($profil->sosial_media ?? false)
                        <div class="d-flex pt-2">
                            @if($profil->sosial_media['facebook'] ?? false)
                                <a class="btn btn-outline-light btn-social" href="{{ $profil->sosial_media['facebook'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            @endif
                            @if($profil->sosial_media['instagram'] ?? false)
                                <a class="btn btn-outline-light btn-social" href="{{ $profil->sosial_media['instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                            @endif
                            @if($profil->sosial_media['youtube'] ?? false)
                                <a class="btn btn-outline-light btn-social" href="{{ $profil->sosial_media['youtube'] }}" target="_blank"><i class="fab fa-youtube"></i></a>
                            @endif
                            @if($profil->sosial_media['twitter'] ?? false)
                                <a class="btn btn-outline-light btn-social" href="{{ $profil->sosial_media['twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Galeri</h4>
                    <div class="row g-2 pt-2">
                        @php
                            $footerGaleri = \App\Models\Galeri::published()->orderBy('urutan')->take(6)->get();
                        @endphp
                        @foreach($footerGaleri as $g)
                            <div class="col-4">
                                <img class="img-fluid bg-light p-1" src="{{ Storage::url($g->gambar) }}" alt="{{ $g->judul }}">
                            </div>
                        @endforeach
                        @if($footerGaleri->count() == 0)
                            <div class="col-12">
                                <p class="text-white-50 small">Belum ada galeri</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">{{ $profil->nama_sekolah ?? 'Sekolah' }}</h4>
                    <p>{{ Str::limit($profil->visi ?? 'Mewujudkan generasi yang berilmu dan berakhlak mulia.', 150) }}</p>
                    <a href="{{ route('login') }}" class="btn btn-primary py-2 px-4">Login Sistem</a>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; {{ date('Y') }} <a class="border-bottom" href="{{ route('landing.index') }}">{{ $profil->nama_sekolah ?? 'Sekolah' }}</a>, All Rights Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="{{ route('landing.index') }}">Beranda</a>
                            <a href="{{ route('landing.profil') }}">Profil</a>
                            <a href="{{ route('landing.kontak') }}">Kontak</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landing/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('landing/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('landing/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('landing/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('landing/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
