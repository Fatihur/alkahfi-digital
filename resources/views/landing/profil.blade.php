@extends('layouts.landing')

@section('title', 'Profil Sekolah - ' . ($profil->nama_sekolah ?? 'Sekolah'))

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Profil Sekolah</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('landing.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Profil</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
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
    <!-- Service End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        @if($profil->foto_gedung ?? false)
                            <img class="img-fluid position-absolute w-100 h-100" src="{{ Storage::url($profil->foto_gedung) }}" alt="Gedung Sekolah" style="object-fit: cover;">
                        @else
                            <img class="img-fluid position-absolute w-100 h-100" src="{{ asset('landing/img/about.jpg') }}" alt="" style="object-fit: cover;">
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Tentang Kami</h6>
                    <h1 class="mb-4">{{ $profil->nama_sekolah ?? 'Sekolah Kami' }}</h1>
                    @if($profil->npsn ?? false)
                        <p class="mb-2"><strong>NPSN:</strong> {{ $profil->npsn }}</p>
                    @endif
                    @if($profil->sejarah ?? false)
                        <p class="mb-4">{{ $profil->sejarah }}</p>
                    @else
                        <p class="mb-4">Sekolah kami berkomitmen untuk memberikan pendidikan terbaik bagi generasi penerus bangsa dengan kurikulum yang berkualitas dan tenaga pengajar yang profesional.</p>
                    @endif
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
    <!-- About End -->

    @if($profil->visi ?? false)
    <!-- Visi Misi Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title bg-light text-start text-primary pe-3">Visi</h6>
                    <h1 class="mb-4">Visi Sekolah</h1>
                    <p class="mb-4">{{ $profil->visi }}</p>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-light text-start text-primary pe-3">Misi</h6>
                    <h1 class="mb-4">Misi Sekolah</h1>
                    @if($profil->misi ?? false)
                        @php
                            $misiList = explode("\n", $profil->misi);
                        @endphp
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
    <!-- Visi Misi End -->
    @endif

    @if($profil->kepala_sekolah ?? false)
    <!-- Kepala Sekolah Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Pimpinan</h6>
                <h1 class="mb-5">Kepala Sekolah</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item bg-light">
                        <div class="overflow-hidden text-center p-4">
                            @if($profil->foto_kepala_sekolah ?? false)
                                <img class="img-fluid rounded-circle" src="{{ Storage::url($profil->foto_kepala_sekolah) }}" alt="{{ $profil->kepala_sekolah }}" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
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
                @if($profil->kata_sambutan ?? false)
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-light p-4 h-100">
                        <h4 class="text-primary mb-3"><i class="fa fa-quote-left me-2"></i>Kata Sambutan</h4>
                        <p class="mb-0" style="text-align: justify;">{{ $profil->kata_sambutan }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Kepala Sekolah End -->
    @endif
@endsection
