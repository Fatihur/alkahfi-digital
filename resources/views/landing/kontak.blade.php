@extends('layouts.landing')

@section('title', 'Kontak - ' . ($profil->nama_sekolah ?? 'Sekolah'))

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Hubungi Kami</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('landing.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Kontak</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Kontak</h6>
                <h1 class="mb-5">Informasi Kontak</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h5>Hubungi Kami</h5>
                    <p class="mb-4">Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan atau membutuhkan informasi lebih lanjut.</p>
                    
                    @if($profil->alamat ?? false)
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                            <i class="fa fa-map-marker-alt text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-primary">Alamat</h5>
                            <p class="mb-0">{{ $profil->alamat }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($profil->telepon ?? false)
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                            <i class="fa fa-phone-alt text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-primary">Telepon</h5>
                            <p class="mb-0"><a href="tel:{{ $profil->telepon }}" class="text-dark text-decoration-none">{{ $profil->telepon }}</a></p>
                        </div>
                    </div>
                    @endif
                    
                    @if($profil->email ?? false)
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                            <i class="fa fa-envelope-open text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-primary">Email</h5>
                            <p class="mb-0"><a href="mailto:{{ $profil->email }}" class="text-dark text-decoration-none">{{ $profil->email }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($profil->website ?? false)
                    <div class="d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center justify-content-center flex-shrink-0 bg-primary" style="width: 50px; height: 50px;">
                            <i class="fa fa-globe text-white"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="text-primary">Website</h5>
                            <p class="mb-0"><a href="{{ $profil->website }}" target="_blank" class="text-dark text-decoration-none">{{ $profil->website }}</a></p>
                        </div>
                    </div>
                    @endif

                    @if($profil->sosial_media ?? false)
                    <div class="d-flex pt-3">
                        @if($profil->sosial_media['facebook'] ?? false)
                            <a class="btn btn-square btn-primary me-2" href="{{ $profil->sosial_media['facebook'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if($profil->sosial_media['instagram'] ?? false)
                            <a class="btn btn-square btn-primary me-2" href="{{ $profil->sosial_media['instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if($profil->sosial_media['youtube'] ?? false)
                            <a class="btn btn-square btn-primary me-2" href="{{ $profil->sosial_media['youtube'] }}" target="_blank"><i class="fab fa-youtube"></i></a>
                        @endif
                        @if($profil->sosial_media['twitter'] ?? false)
                            <a class="btn btn-square btn-primary" href="{{ $profil->sosial_media['twitter'] }}" target="_blank"><i class="fab fa-twitter"></i></a>
                        @endif
                    </div>
                    @endif
                </div>
                
                <div class="col-lg-8 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    @if($profil->maps_embed ?? false)
                        <div class="position-relative rounded overflow-hidden w-100" style="min-height: 400px;">
                            {!! $profil->maps_embed !!}
                        </div>
                    @elseif($profil->foto_gedung ?? false)
                        <img class="img-fluid rounded w-100" src="{{ Storage::url($profil->foto_gedung) }}" alt="Gedung Sekolah" style="min-height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="min-height: 400px;">
                            <div class="text-center text-muted">
                                <i class="fa fa-map fa-5x mb-3"></i>
                                <p>Peta lokasi belum tersedia</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <!-- Info Start -->
    <div class="container-xxl py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-white p-4 h-100 text-center">
                        <i class="fa fa-clock fa-3x text-primary mb-4"></i>
                        <h5>Jam Operasional</h5>
                        <p class="mb-0">Senin - Jumat: 07:00 - 16:00<br>Sabtu: 07:00 - 12:00</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-white p-4 h-100 text-center">
                        <i class="fa fa-phone fa-3x text-primary mb-4"></i>
                        <h5>Layanan Informasi</h5>
                        <p class="mb-0">Hubungi kami untuk informasi<br>pendaftaran dan akademik</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bg-white p-4 h-100 text-center">
                        <i class="fa fa-envelope fa-3x text-primary mb-4"></i>
                        <h5>Email Support</h5>
                        <p class="mb-0">Kirimkan pertanyaan Anda<br>melalui email resmi kami</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Info End -->
@endsection

@push('styles')
<style>
    .container-xxl iframe {
        width: 100%;
        height: 400px;
        border: 0;
    }
</style>
@endpush
