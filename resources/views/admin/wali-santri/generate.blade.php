@extends('layouts.admin')

@section('title', 'Generate Akun Wali Santri')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Generate Akun Otomatis</h1>
            <p class="page-subtitle">Buat akun wali santri secara otomatis untuk santri yang belum memiliki wali.</p>
        </div>
    </div>

    @if($santriTanpaWali->count() == 0)
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Semua santri aktif sudah memiliki akun wali. Tidak ada santri yang perlu dibuatkan akun.
        </div>
        <a href="{{ route('admin.wali-santri.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    @else
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Pilih santri yang akan dibuatkan akun wali</span>
                <span class="badge badge-info">{{ $santriTanpaWali->count() }} santri tanpa wali</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.wali-santri.generate.store') }}" method="POST" id="generateForm">
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Hubungan Default <span class="text-danger">*</span></label>
                                <select class="form-control form-select @error('hubungan_default') is-invalid @enderror" name="hubungan_default" required>
                                    <option value="ayah">Ayah</option>
                                    <option value="ibu">Ibu</option>
                                    <option value="wali" selected>Wali</option>
                                </select>
                                @error('hubungan_default')
                                    <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Hubungan default yang akan digunakan untuk semua akun yang dibuat</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-check">
                                    <input type="checkbox" class="form-check-input" id="selectAll">
                                    <span>Pilih Semua Santri</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                    </th>
                                    <th>NIS</th>
                                    <th>Nama Santri</th>
                                    <th>Kelas</th>
                                    <th>Angkatan</th>
                                    <th>Email yang akan dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($santriTanpaWali as $santri)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input santri-checkbox" name="santri_ids[]" value="{{ $santri->id }}">
                                        </td>
                                        <td>{{ $santri->nis }}</td>
                                        <td>{{ $santri->nama_lengkap }}</td>
                                        <td>{{ $santri->kelas->nama ?? '-' }}</td>
                                        <td>{{ $santri->angkatan->nama ?? '-' }}</td>
                                        <td>
                                            <code>{{ Str::slug($santri->nama_lengkap, '.') }}@wali.pesantren.id</code>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Password akan di-generate secara otomatis dan ditampilkan setelah proses selesai.
                        Pastikan untuk menyimpan informasi login tersebut.
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span id="selectedCount" class="text-muted">0 santri dipilih</span>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.wali-santri.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success" id="submitBtn" disabled>
                                <i class="bi bi-magic"></i> Generate Akun (<span id="btnCount">0</span>)
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @push('scripts')
    <script>
        const checkboxes = document.querySelectorAll('.santri-checkbox');
        const selectAll = document.getElementById('selectAll');
        const checkAll = document.getElementById('checkAll');
        const selectedCount = document.getElementById('selectedCount');
        const submitBtn = document.getElementById('submitBtn');
        const btnCount = document.getElementById('btnCount');

        function updateCount() {
            const checked = document.querySelectorAll('.santri-checkbox:checked').length;
            selectedCount.textContent = checked + ' santri dipilih';
            btnCount.textContent = checked;
            submitBtn.disabled = checked === 0;
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                if (checkAll) checkAll.checked = this.checked;
                updateCount();
            });
        }

        if (checkAll) {
            checkAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
                if (selectAll) selectAll.checked = this.checked;
                updateCount();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = document.querySelectorAll('.santri-checkbox:checked').length === checkboxes.length;
                if (selectAll) selectAll.checked = allChecked;
                if (checkAll) checkAll.checked = allChecked;
                updateCount();
            });
        });

        document.getElementById('generateForm')?.addEventListener('submit', function(e) {
            const checked = document.querySelectorAll('.santri-checkbox:checked').length;
            if (checked === 0) {
                e.preventDefault();
                alert('Pilih minimal satu santri');
                return false;
            }
            return confirm('Generate ' + checked + ' akun wali santri?');
        });
    </script>
    @endpush
@endsection
