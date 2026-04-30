{{--
================================================================================
FILE        : profil.blade.php
DESKRIPSI   : Halaman profil sekolah yang menampilkan informasi lengkap
              tentang sekolah: visi, misi, sejarah, dan data kepala sekolah
LOKASI      : resources/views/landing/profil.blade.php
CONTROLLER  : LandingController@profil
ROUTE       : GET /profil (landing.profil)
================================================================================

CONTOH MODIFIKASI STYLING:
- Ubah ukuran foto: style="min-height: 500px;"
- Tambah border: class="border border-primary border-3"
- Ubah bg visi-misi: bg-light -> bg-white
================================================================================
--}}

{{-- @extends: Menggunakan layout landing page --}}
@extends('layouts.landing')

{{-- @section('title'): Judul halaman dengan nama sekolah dinamis --}}
@section('title', 'Profil Sekolah - ' . ($profil->nama_sekolah ?? 'Sekolah'))

{{-- @section('content'): Konten utama halaman --}}
@section('content')
    {{-- ============================================ --}}
    {{-- PAGE HEADER / BREADCRUMB SECTION            --}}
    {{-- ============================================ --}}
    {{-- bg-primary: Background color primary --}}
    {{-- page-header: Class custom untuk styling header halaman --}}
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Profil Sekolah</h1>
                    {{-- Breadcrumb: Navigasi hierarki halaman --}}
                    {{-- aria-label: Aksesibilitas untuk screen reader --}}
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            {{-- breadcrumb-item: Item navigasi --}}
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('landing.index') }}">Beranda</a></li>
                            {{-- active: Item halaman aktif --}}
                            <li class="breadcrumb-item text-white active" aria-current="page">Profil</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    {{-- End Header --}}

    {{-- ============================================ --}}
    {{-- SERVICES SECTION - Keunggulan Sekolah       --}}
    {{-- ============================================ --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                {{-- col-lg-3: 4 kolom pada layar large --}}
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Tenaga Pengajar</h5>
                            <p>Pengajar profesional dan berpengalaman</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                            <h5 class="mb-3">Fasilitas Modern</h5>
                            <p>Fasilitas pembelajaran yang lengkap</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-home text-primary mb-4"></i>
                            <h5 class="mb-3">Lingkungan Nyaman</h5>
                            <p>Lingkungan belajar yang kondusif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Kurikulum Terbaik</h5>
                            <p>Kurikulum terintegrasi berkualitas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Services --}}

    {{-- ============================================ --}}
    {{-- ABOUT SECTION - Informasi Detail Sekolah    --}}
    {{-- ============================================ --}}
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                {{-- Kolom foto gedung sekolah --}}
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        {{-- Ternary operator dengan null coalescing --}}
                        @if($profil->foto_gedung ?? false)
                            <img class="img-fluid position-absolute w-100 h-100" src="{{ Storage::url($profil->foto_gedung) }}" alt="Gedung Sekolah" style="object-fit: cover;">
                        @else
                            <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('landing/img/about.jpg') }}" alt="" style="object-fit: cover;">
                        @endif
                    </div>
                </div>
                {{-- Kolom informasi teks --}}
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Tentang Kami</h6>
                    <h1 class="mb-4">{{ $profil->nama_sekolah ?? 'Sekolah Kami' }}</h1>
                    {{-- Tampilkan NPSN jika tersedia --}}
                    @if($profil->npsn ?? false)
                        <p class="mb-2"><strong>NPSN:</strong> {{ $profil->npsn }}</p>
                    @endif
                    {{-- Tampilkan sejarah dengan fallback --}}
                    @if($profil->sejarah ?? false)
                        <p class="mb-4">{{ $profil->sejarah }}</p>
                    @else
                        <p class="mb-4">Sekolah kami berkomitmen untuk memberikan pendidikan terbaik bagi generasi penerus bangsa dengan kurikulum yang berkualitas dan tenaga pengajar yang profesional.</p>
                    @endif
                    {{-- Grid informasi kontak --}}
                    <div class="row gy-2 gx-4 mb-4">
                        @if($profil->alamat ?? false)
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ Str::limit($profil->alamat, 50) }}</p>
                            </div>
                        @endif
                        @if($profil->telepon ?? false)
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-phone-alt text-primary me-2"></i>{{ $profil->telepon }}</p>
                            </div>
                        @endif
                        @if($profil->email ?? false)
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-envelope text-primary me-2"></i>{{ $profil->email }}</p>
                            </div>
                        @endif
                        @if($profil->website ?? false)
                            <div class="col-sm-6">
                                <p class="mb-0"><i class="fa fa-globe text-primary me-2"></i>{{ $profil->website }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End About --}}

    {{-- ============================================ --}}
    {{-- VISI MISI SECTION                           --}}
    {{-- ============================================ --}}
    {{-- Tampil hanya jika ada data visi --}}
    @if($profil->visi ?? false)
    {{-- bg-light: Background abu-abu muda --}}
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="row g-5">
                {{-- Kolom Visi --}}
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-light text-start text-primary pe-3">Visi</h6>
                    <h1 class="mb-4">Visi Sekolah</h1>
                    <p class="mb-4">{{ $profil->visi }}</p>
                </div>
                {{-- Kolom Misi --}}
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-light text-start text-primary pe-3">Misi</h6>
                    <h1 class="mb-4">Misi Sekolah</h1>
                    @php
                        $misiList = !empty($profil->misi) ? preg_split('/\r\n|\r|\n/', $profil->misi) : [];
                    @endphp
                    @if(!empty($misiList))
                        {{-- list-unstyled: List tanpa bullet default --}}
                        <ul class="list-unstyled">
                            @foreach($misiList as $misi)
                                @if(trim($misi))
                                    <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>{{ trim($misi) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    {{-- End Visi Misi --}}

    {{-- ============================================ --}}
    {{-- KEPLA SEKOLAH SECTION                       --}}
    {{-- ============================================ --}}
    @if($profil->kepala_sekolah ?? false)
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Pimpinan</h6>
                <h1 class="mb-5">Kepala Sekolah</h1>
            </div>
            <div class="row g-4 justify-content-center">
                {{-- Foto Kepala Sekolah --}}
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden text-center p-4">
                            @if($profil->foto_kepala_sekolah ?? false)
                                {{-- rounded-circle: Membuat gambar bulat --}}
                                <img class="img-fluid rounded-circle" src="{{ Storage::url($profil->foto_kepala_sekolah) }}" alt="{{ $profil->kepala_sekolah }}" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                {{-- Placeholder icon jika tidak ada foto --}}
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 200px; height: 200px;">
                                    <i class="fa fa-user fa-5x text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="text-center p-4">
                            <h5 class="mb-0">{{ $profil->kepala_sekolah }}</h5>
                            <small>Kepala Sekolah</small>
                        </div>
                    </div>
                </div>
                {{-- Kata Sambutan --}}
                @if($profil->kata_sambutan ?? false)
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.3s">
                    {{-- h-100: Height 100% --}}
                    <div class="bg-light p-4 h-100">
                        <h4 class="text-primary mb-3"><i class="fa fa-quote-left me-2"></i>Kata Sambutan</h4>
                        {{-- text-align justify: Rata kanan kiri --}}
                        <p class="mb-0" style="text-align: justify;">{{ $profil->kata_sambutan }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
    {{-- End Kepala Sekolah --}}
@endsection
