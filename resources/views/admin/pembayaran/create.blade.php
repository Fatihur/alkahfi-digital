@extends('layouts.admin')

@section('title', 'Input Pembayaran Manual')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Input Pembayaran Manual</h1>
            <p class="page-subtitle">Catat pembayaran tunai atau transfer.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pembayaran.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Santri <span class="text-danger">*</span></label>
                            <select name="santri_id" id="santri_id" class="form-control form-select" required>
                                <option value="">Pilih Santri</option>
                                @foreach($santriList as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tagihan <span class="text-danger">*</span></label>
                            <select name="tagihan_id" id="tagihan_id" class="form-control form-select" required>
                                <option value="">Pilih Santri Dulu</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Jumlah Bayar (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" min="0" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select name="metode_pembayaran" class="form-control form-select" required>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3"></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan Pembayaran</button>
                    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('santri_id').addEventListener('change', function() {
        const santriId = this.value;
        const tagihanSelect = document.getElementById('tagihan_id');
        
        if (!santriId) {
            tagihanSelect.innerHTML = '<option value="">Pilih Santri Dulu</option>';
            return;
        }
        
        tagihanSelect.innerHTML = '<option value="">Loading...</option>';
        
        fetch(`{{ url('admin/pembayaran/tagihan') }}/${santriId}`)
            .then(response => response.json())
            .then(data => {
                let options = '<option value="">Pilih Tagihan</option>';
                data.forEach(t => {
                    options += `<option value="${t.id}" data-total="${t.total_bayar}">${t.nama_tagihan} - Rp ${Number(t.total_bayar).toLocaleString('id-ID')}</option>`;
                });
                tagihanSelect.innerHTML = options;
            })
            .catch(err => {
                tagihanSelect.innerHTML = '<option value="">Error loading</option>';
            });
    });
    
    document.getElementById('tagihan_id').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const total = selected.dataset.total || 0;
        document.getElementById('jumlah_bayar').value = total;
    });
</script>
@endpush
