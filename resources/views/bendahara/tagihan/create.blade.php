@extends('layouts.bendahara')

@section('title', 'Buat Tagihan')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Buat Tagihan</h1>
            <p class="page-subtitle">Buat tagihan SPP baru untuk santri.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0;padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('bendahara.tagihan.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tipe Penerapan <span class="text-danger">*</span></label>
                            <select name="tipe_tagihan" id="tipe_tagihan" class="form-control form-select" required>
                                <option value="individual">Per Santri</option>
                                <option value="kelas">Per Kelas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group" id="santri_group">
                            <label class="form-label">Santri <span class="text-danger">*</span></label>
                            <select name="santri_id" class="form-control form-select">
                                <option value="">Pilih Santri</option>
                                @foreach($santriList as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="kelas_group" style="display:none;">
                            <label class="form-label">Kelas <span class="text-danger">*</span></label>
                            <select name="kelas_id" class="form-control form-select">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Tagihan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_tagihan" class="form-control" placeholder="Contoh: SPP Januari 2025" required>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Periode</label>
                            <input type="text" name="periode" class="form-control" placeholder="Contoh: Januari 2025">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-control form-select">
                                <option value="">Pilih Bulan</option>
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bulan)
                                    <option value="{{ $i+1 }}">{{ $bulan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="nominal" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_jatuh_tempo" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('bendahara.tagihan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('tipe_tagihan').addEventListener('change', function() {
        document.getElementById('santri_group').style.display = 'none';
        document.getElementById('kelas_group').style.display = 'none';
        
        if (this.value === 'individual') {
            document.getElementById('santri_group').style.display = 'block';
        } else if (this.value === 'kelas') {
            document.getElementById('kelas_group').style.display = 'block';
        }
    });
</script>
@endpush
