@extends('layouts.admin')

@section('title', 'Profil Sekolah')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Profil Sekolah</h1>
            <p class="page-subtitle">Kelola informasi profil sekolah untuk landing page.</p>
        </div>
        <a href="{{ route('landing.index') }}" target="_blank" class="btn btn-secondary"><i class="bi bi-eye"></i> Lihat Landing Page</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.landing.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h5 class="mb-4">Informasi Umum</h5>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_sekolah" class="form-control" value="{{ old('nama_sekolah', $profil->nama_sekolah) }}" required>
                            @error('nama_sekolah')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">NPSN</label>
                            <input type="text" name="npsn" class="form-control" value="{{ old('npsn', $profil->npsn) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $profil->alamat) }}</textarea>
                    @error('alamat')
                        <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $profil->telepon) }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $profil->email) }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Website</label>
                            <input type="url" name="website" class="form-control" value="{{ old('website', $profil->website) }}" placeholder="https://...">
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="mb-4">Visi, Misi & Sejarah</h5>

                <div class="form-group">
                    <label class="form-label">Visi</label>
                    <textarea name="visi" class="form-control" rows="3">{{ old('visi', $profil->visi) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Misi</label>
                    <textarea name="misi" class="form-control" rows="4" placeholder="Pisahkan dengan enter untuk setiap poin">{{ old('misi', $profil->misi) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Sejarah</label>
                    <textarea name="sejarah" class="form-control" rows="4">{{ old('sejarah', $profil->sejarah) }}</textarea>
                </div>

                <hr>
                <h5 class="mb-4">Kepala Sekolah</h5>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nama Kepala Sekolah</label>
                            <input type="text" name="kepala_sekolah" class="form-control" value="{{ old('kepala_sekolah', $profil->kepala_sekolah) }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Foto Kepala Sekolah</label>
                            <input type="file" name="foto_kepala_sekolah" class="form-control" accept="image/*">
                            @if($profil->foto_kepala_sekolah)
                                <small class="text-muted">File saat ini: <a href="{{ Storage::url($profil->foto_kepala_sekolah) }}" target="_blank">Lihat</a></small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Kata Sambutan</label>
                    <textarea name="kata_sambutan" class="form-control" rows="4">{{ old('kata_sambutan', $profil->kata_sambutan) }}</textarea>
                </div>

                <hr>
                <h5 class="mb-4">Logo & Foto</h5>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Logo Sekolah</label>
                            @if($profil->logo)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($profil->logo) }}" alt="Logo" style="max-height: 80px;">
                                </div>
                            @endif
                            <input type="file" name="logo" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Foto Gedung</label>
                            @if($profil->foto_gedung)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($profil->foto_gedung) }}" alt="Gedung" style="max-height: 80px;">
                                </div>
                            @endif
                            <input type="file" name="foto_gedung" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="mb-4">Sosial Media</h5>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label"><i class="bi bi-facebook text-primary"></i> Facebook</label>
                            <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $profil->sosial_media['facebook'] ?? '') }}" placeholder="https://facebook.com/...">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label"><i class="bi bi-instagram text-danger"></i> Instagram</label>
                            <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $profil->sosial_media['instagram'] ?? '') }}" placeholder="https://instagram.com/...">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label"><i class="bi bi-youtube text-danger"></i> YouTube</label>
                            <input type="url" name="youtube" class="form-control" value="{{ old('youtube', $profil->sosial_media['youtube'] ?? '') }}" placeholder="https://youtube.com/...">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label"><i class="bi bi-twitter-x"></i> Twitter/X</label>
                            <input type="url" name="twitter" class="form-control" value="{{ old('twitter', $profil->sosial_media['twitter'] ?? '') }}" placeholder="https://x.com/...">
                        </div>
                    </div>
                </div>

                <hr>
                <h5 class="mb-4">Peta Lokasi</h5>

                <div class="form-group">
                    <label class="form-label">Embed Google Maps</label>
                    <textarea name="maps_embed" class="form-control" rows="3" placeholder='<iframe src="https://www.google.com/maps/embed?..." ...></iframe>'>{{ old('maps_embed', $profil->maps_embed) }}</textarea>
                    <small class="text-muted">Salin kode embed dari Google Maps</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
