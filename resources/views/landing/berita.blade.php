@extends('layouts.landing')

@section('title', 'Berita - ' . ($profil->nama_sekolah ?? 'Sekolah'))

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Berita & Artikel</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('landing.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Berita</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Search Start -->
    <div class="container-xxl py-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="{{ route('landing.berita') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Search End -->

    <!-- Berita Start -->
    <div class="container-xxl py-5">
        <div class="container">
            @if($berita->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach($berita as $item)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            @if($item->gambar)
                                <img class="img-fluid" src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" style="height: 200px; width: 100%; object-fit: cover;">
                            @else
                                <img class="img-fluid" src="{{ asset('landing/img/course-1.jpg') }}" alt="" style="height: 200px; width: 100%; object-fit: cover;">
                            @endif
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="{{ route('landing.berita.detail', $item->slug) }}" class="flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 30px;">Baca Selengkapnya</a>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                            <span class="badge bg-primary mb-2">{{ $item->kategori }}</span>
                            <h5 class="mb-4">{{ Str::limit($item->judul, 50) }}</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-calendar text-primary me-2"></i>{{ $item->tanggal_publikasi?->format('d M Y') }}</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-eye text-primary me-2"></i>{{ $item->views }} views</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $berita->links() }}
            </div>
            @else
            <div class="text-center py-5 wow fadeInUp" data-wow-delay="0.1s">
                <i class="fa fa-newspaper fa-5x text-muted mb-4"></i>
                <h4 class="text-muted">Tidak ada berita yang ditemukan.</h4>
                @if(request('search'))
                    <a href="{{ route('landing.berita') }}" class="btn btn-primary mt-3">Lihat Semua Berita</a>
                @endif
            </div>
            @endif
        </div>
    </div>
    <!-- Berita End -->
@endsection
