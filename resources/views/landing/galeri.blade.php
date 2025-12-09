@extends('layouts.landing')

@section('title', 'Galeri - ' . ($profil->nama_sekolah ?? 'Sekolah'))

@section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Galeri Foto</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="{{ route('landing.index') }}">Beranda</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Galeri</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Galeri Start -->
    <div class="container-xxl py-5">
        <div class="container">
            @if($galeri->count() > 0)
            <div class="row g-4">
                @foreach($galeri as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative overflow-hidden rounded" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#galeriModal{{ $item->id }}">
                        <img class="img-fluid w-100" src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                            <h6 class="text-white mb-1">{{ Str::limit($item->judul, 25) }}</h6>
                            <small class="text-white-50">{{ $item->kategori }}</small>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="galeriModal{{ $item->id }}" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $item->judul }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" class="img-fluid rounded">
                                @if($item->deskripsi)
                                    <p class="mt-3 text-muted">{{ $item->deskripsi }}</p>
                                @endif
                                <span class="badge bg-primary">{{ $item->kategori }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center mt-5">
                {{ $galeri->links() }}
            </div>
            @else
            <div class="text-center py-5 wow fadeInUp" data-wow-delay="0.1s">
                <i class="fa fa-images fa-5x text-muted mb-4"></i>
                <h4 class="text-muted">Belum ada galeri yang dipublikasikan.</h4>
            </div>
            @endif
        </div>
    </div>
    <!-- Galeri End -->
@endsection
