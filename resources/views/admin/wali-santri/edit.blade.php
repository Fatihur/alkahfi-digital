@extends('layouts.admin')

@section('title', 'Edit Wali Santri')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Wali Santri</h1>
            <p class="page-subtitle">Ubah data wali santri: {{ $wali_santri->name }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.wali-santri.update', $wali_santri) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $wali_santri->name) }}" required>
                            @error('name')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $wali_santri->email) }}" required>
                            @error('email')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $wali_santri->no_hp) }}">
                            @error('no_hp')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check form-switch">
                                <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $wali_santri->is_active) ? 'checked' : '' }}>
                                <span>Akun Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak diubah">
                            @error('password')
                                <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Hubungkan dengan Santri</h5>

                <div id="santri-container">
                    @foreach($santriTerpilih as $index => $santriId)
                    <div class="santri-item">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Pilih Santri <span class="text-danger">*</span></label>
                                    <select class="form-control form-select" name="santri_ids[]" required>
                                        <option value="">-- Pilih Santri --</option>
                                        @foreach($semuaSantri as $santri)
                                            <option value="{{ $santri->id }}" {{ $santriId == $santri->id ? 'selected' : '' }}>
                                                {{ $santri->nama_lengkap }} ({{ $santri->nis }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Hubungan <span class="text-danger">*</span></label>
                                    <select class="form-control form-select" name="hubungan[]" required>
                                        <option value="ayah" {{ ($hubunganSantri[$santriId] ?? '') == 'ayah' ? 'selected' : '' }}>Ayah</option>
                                        <option value="ibu" {{ ($hubunganSantri[$santriId] ?? '') == 'ibu' ? 'selected' : '' }}>Ibu</option>
                                        <option value="wali" {{ ($hubunganSantri[$santriId] ?? '') == 'wali' ? 'selected' : '' }}>Wali</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2 d-flex align-items-end">
                                <div class="form-group">
                                    <button type="button" class="btn btn-danger btn-sm remove-santri" style="{{ count($santriTerpilih) > 1 ? '' : 'display: none;' }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mb-4">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-santri">
                        <i class="bi bi-plus"></i> Tambah Santri Lain
                    </button>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.wali-santri.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        const semuaSantri = @json($semuaSantri);

        document.getElementById('add-santri').addEventListener('click', function() {
            const container = document.getElementById('santri-container');
            const items = container.querySelectorAll('.santri-item');

            let optionsHtml = '<option value="">-- Pilih Santri --</option>';
            semuaSantri.forEach(santri => {
                optionsHtml += `<option value="${santri.id}">${santri.nama_lengkap} (${santri.nis})</option>`;
            });

            const newItem = document.createElement('div');
            newItem.className = 'santri-item';
            newItem.innerHTML = `
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Pilih Santri <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="santri_ids[]" required>
                                ${optionsHtml}
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Hubungan <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="hubungan[]" required>
                                <option value="ayah">Ayah</option>
                                <option value="ibu">Ibu</option>
                                <option value="wali" selected>Wali</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2 d-flex align-items-end">
                        <div class="form-group">
                            <button type="button" class="btn btn-danger btn-sm remove-santri">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(newItem);
            updateRemoveButtons();
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-santri')) {
                e.target.closest('.santri-item').remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const items = document.querySelectorAll('.santri-item');
            items.forEach((item) => {
                const removeBtn = item.querySelector('.remove-santri');
                removeBtn.style.display = items.length > 1 ? '' : 'none';
            });
        }
    </script>
    @endpush
@endsection
