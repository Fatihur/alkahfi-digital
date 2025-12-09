@extends('layouts.landing')

@section('title', $berita->judul . ' - ' . ($profil->nama_sekolah ?? 'Sekolah'))

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-5 text-white animated slideInDown">{{ $berita->judul }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('landing.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('landing.berita') }}">Berita</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Detail Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                    <article>
                        @if($berita->gambar)
                            <img class="img-fluid w-100 rounded mb-4" src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}">
                        @endif
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <span class="badge bg-primary py-2 px-3">{{ $berita->kategori }}</span>
                            <span class="text-muted"><i class="fa fa-calendar me-2"></i>{{ $berita->tanggal_publikasi?->format('d F Y') }}</span>
                            <span class="text-muted"><i class="fa fa-user me-2"></i>{{ $berita->createdBy->name ?? 'Admin' }}</span>
                            <span class="text-muted"><i class="fa fa-eye me-2"></i>{{ $berita->views }} kali dilihat</span>
                        </div>
                        @if($berita->ringkasan)
                            <p class="lead mb-4">{{ $berita->ringkasan }}</p>
                        @endif
                        <div class="content trix-content" style="text-align: justify;">
                            {!! $berita->konten !!}
                        </div>
                    </article>
                    <div class="mt-5">
                        <a href="{{ route('landing.berita') }}" class="btn btn-primary py-3 px-5">
                            <i class="fa fa-arrow-left me-2"></i>Kembali ke Berita
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="bg-light p-4 rounded mb-4">
                        <h4 class="text-primary mb-4">Berita Lainnya</h4>
                        @if($beritaLainnya->count() > 0)
                            @foreach($beritaLainnya as $item)
                            <a href="{{ route('landing.berita.detail', $item->slug) }}" class="d-flex align-items-center mb-3 text-decoration-none">
                                @if($item->gambar)
                                    <img class="flex-shrink-0 rounded" src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" style="width: 80px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="flex-shrink-0 rounded bg-primary d-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                                        <i class="fa fa-newspaper text-white"></i>
                                    </div>
                                @endif
                                <div class="ps-3">
                                    <h6 class="text-dark mb-1">{{ Str::limit($item->judul, 40) }}</h6>
                                    <small class="text-muted">{{ $item->tanggal_publikasi?->format('d M Y') }}</small>
                                </div>
                            </a>
                            @endforeach
                        @else
                            <p class="text-muted">Tidak ada berita lainnya.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->
@endsection
