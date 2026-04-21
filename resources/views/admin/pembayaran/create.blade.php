{{--
================================================================================
FILE        : create.blade.php
DESKRIPSI   : Form input pembayaran manual untuk pencatatan pembayaran tunai
              atau transfer. Form ini memungkinkan admin memilih santri,
              tagihan yang tersedia, mengisi jumlah bayar, metode pembayaran,
              tanggal, dan catatan. Dilengkapi dengan AJAX untuk mengambil
              tagihan santri secara dinamis.
LOKASI      : resources/views/admin/pembayaran/create.blade.php
CONTROLLER  : PembayaranController@create, PembayaranController@store
ROUTE       : GET /admin/pembayaran/create (name: admin.pembayaran.create)
              POST /admin/pembayaran (name: admin.pembayaran.store)
================================================================================
--}}

{{--
    @extends('layouts.admin')
    Directive Blade yang menyatakan view ini mewarisi layout utama admin.
    Layout ini berisi struktur HTML dasar, navbar, sidebar, dan footer.
--}}
@extends('layouts.admin')

{{--
    @section('title', 'Input Pembayaran Manual')
    Menentukan judul halaman yang ditampilkan di tab browser.
    Bagian ini akan di-render di layout parent menggunakan @yield('title').
--}}
@section('title', 'Input Pembayaran Manual')

{{--
    @section('content')
    Memulai bagian konten utama halaman. Semua HTML di dalam section ini
    akan di-inject ke dalam @yield('content') di layout parent.
--}}
@section('content')
    {{--
        Page Header: Bagian atas halaman dengan judul dan deskripsi
        Class 'page-header' adalah styling kustom untuk konsistensi UI
    --}}
    <div class="page-header">
        <div>
            {{-- Judul halaman utama --}}
            <h1 class="page-title">Input Pembayaran Manual</h1>
            {{-- Penjelasan singkat fungsi halaman --}}
            <p class="page-subtitle">Catat pembayaran tunai atau transfer.</p>
        </div>
    </div>

    {{--
        Card Container: Wrapper utama form dengan styling card
        Card-body memberikan padding internal untuk konten
    --}}
    <div class="card">
        <div class="card-body">
            {{--
                FORM INPUT PEMBAYARAN
                
                action: URL tujuan submit form menggunakan route helper
                        route('admin.pembayaran.store') menghasilkan /admin/pembayaran
                method: POST untuk menyimpan data baru
                
                CSRF Protection:
                @csrf directive wajib untuk form POST di Laravel
                Menghasilkan input hidden dengan token CSRF untuk keamanan
                mencegah serangan Cross-Site Request Forgery
            --}}
            <form action="{{ route('admin.pembayaran.store') }}" method="POST">
                @csrf

                {{--
                    BARIS 1: PEMILIHAN SANTRI DAN TAGIHAN
                    
                    Layout menggunakan grid Bootstrap (row dan col-*)
                    col-6 = 50% lebar pada semua breakpoint
                    
                    CONTOH MODIFIKASI LAYOUT:
                    - col-md-6 col-12 : Full width di mobile, 50% di desktop
                    - col-lg-4        : 33% lebar pada layar besar
                --}}
                <div class="row">
                    {{-- Kolom Kiri: Pemilihan Santri --}}
                    <div class="col-6">
                        {{--
                            Form Group: Wrapper untuk label dan input
                            form-label: Styling label form
                            text-danger: Warna merah untuk indikator wajib
                        --}}
                        <div class="form-group">
                            <label class="form-label">Santri <span class="text-danger">*</span></label>
                            {{--
                                Select Dropdown Santri
                                
                                name="santri_id": Nama field yang dikirim ke server
                                id="santri_id": ID untuk JavaScript selector
                                class="form-control form-select": Styling Bootstrap
                                required: Validasi HTML5, field wajib diisi
                                
                                Options:
                                - Option pertama kosong sebagai placeholder
                                - @foreach loop untuk menampilkan semua santri
                                - Format: NIS - Nama Lengkap
                            --}}
                            <select name="santri_id" id="santri_id" class="form-control form-select" required>
                                <option value="">Pilih Santri</option>
                                {{--
                                    @foreach($santriList as $s)
                                    Looping data santri dari controller
                                    $s->id sebagai value, $s->nis dan $s->nama_lengkap sebagai label
                                --}}
                                @foreach($santriList as $s)
                                    <option value="{{ $s->id }}">{{ $s->nis }} - {{ $s->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Pemilihan Tagihan --}}
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Tagihan <span class="text-danger">*</span></label>
                            {{--
                                Select Dropdown Tagihan
                                
                                ID 'tagihan_id' digunakan JavaScript untuk:
                                1. Terima data tagihan via AJAX saat santri dipilih
                                2. Trigger autofill jumlah bayar saat tagihan dipilih
                                
                                Initial state: Hanya menampilkan placeholder
                                Options akan diisi dinamis via JavaScript
                            --}}
                            <select name="tagihan_id" id="tagihan_id" class="form-control form-select" required>
                                <option value="">Pilih Santri Dulu</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{--
                    BARIS 2: DETAIL PEMBAYARAN
                    
                    3 kolom dengan lebar sama (col-4 = 33.33%)
                    Berisi: Jumlah Bayar, Metode Pembayaran, Tanggal Bayar
                --}}
                <div class="row">
                    {{-- Kolom Jumlah Bayar --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Jumlah Bayar (Rp) <span class="text-danger">*</span></label>
                            {{--
                                Input Number untuk Jumlah Bayar
                                
                                type="number": Input numerik dengan kontrol spinner
                                min="0": Validasi nilai tidak boleh negatif
                                id="jumlah_bayar": Target autofill dari JavaScript
                                
                                CONTOH MODIFIKASI:
                                - type="text" dengan class currency formatting
                                - placeholder="Contoh: 1500000"
                                - step="1000" untuk increment per ribuan
                            --}}
                            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" min="0" required>
                        </div>
                    </div>

                    {{-- Kolom Metode Pembayaran --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            {{--
                                Select Metode Pembayaran
                                
                                Options statis (hardcoded):
                                - tunai   : Pembayaran langsung dengan uang tunai
                                - transfer: Pembayaran via transfer bank/e-wallet
                                
                                CONTOH PENAMBAHAN OPTIONS:
                                <option value="qris">QRIS</option>
                                <option value="virtual_account">Virtual Account</option>
                            --}}
                            <select name="metode_pembayaran" class="form-control form-select" required>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>

                    {{-- Kolom Tanggal Bayar --}}
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                            {{--
                                Input Date untuk Tanggal Bayar
                                
                                type="date": Input tanggal dengan date picker native
                                value="{{ date('Y-m-d') }}": Default ke tanggal hari ini
                                Format: YYYY-MM-DD (2024-01-15)
                                
                                CONTOH MODIFIKASI DEFAULT VALUE:
                                - value="{{ now()->format('Y-m-d') }}" (Carbon)
                                - value="{{ old('tanggal_bayar', date('Y-m-d')) }}" (dengan old input)
                            --}}
                            <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                {{--
                    BARIS 3: CATATAN PEMBAYARAN
                    
                    Textarea untuk informasi tambahan yang tidak wajib diisi
                    rows="3": Tinggi textarea setara 3 baris teks
                --}}
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="3"></textarea>
                </div>

                {{--
                    TOMBOL AKSI FORM
                    
                    d-flex gap-2: Flexbox dengan gap 0.5rem antar elemen
                    
                    Tombol Simpan:
                    - type="submit": Trigger form submission
                    - btn-primary: Warna biru utama
                    - bi bi-check: Icon centang Bootstrap Icons
                    
                    Tombol Batal:
                    - route('admin.pembayaran.index'): Redirect ke halaman daftar
                    - btn-secondary: Warna abu-abu
                    
                    CONTOH TAMBAHAN TOMBOL:
                    <button type="reset" class="btn btn-warning">Reset</button>
                --}}
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan Pembayaran</button>
                    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

{{--
    @push('scripts')
    Menambahkan JavaScript khusus halaman ini ke stack 'scripts'.
    Script ini akan di-render di layout parent pada posisi @stack('scripts').
    
    FUNGSI JAVASCRIPT:
    1. Event listener change pada dropdown santri untuk fetch tagihan via AJAX
    2. Event listener change pada dropdown tagihan untuk autofill jumlah bayar
--}}
@push('scripts')
<script>
    {{--
        EVENT LISTENER 1: PERUBAHAN PEMILIHAN SANTRI
        
        Ketika admin memilih santri dari dropdown:
        1. Ambil value (santri_id) yang dipilih
        2. Jika kosong, reset dropdown tagihan ke default
        3. Jika ada value, lakukan fetch request ke endpoint tagihan
        4. Render hasil response sebagai option tagihan
    --}}
    document.getElementById('santri_id').addEventListener('change', function() {
        {{-- Ambil nilai santri_id yang dipilih --}}
        const santriId = this.value;
        {{-- Reference ke dropdown tagihan untuk manipulasi --}}
        const tagihanSelect = document.getElementById('tagihan_id');
        
        {{-- Validasi: Jika santri belum dipilih, reset tagihan --}}
        if (!santriId) {
            tagihanSelect.innerHTML = '<option value="">Pilih Santri Dulu</option>';
            return;
        }
        
        {{-- Tampilkan loading state saat fetch berlangsung --}}
        tagihanSelect.innerHTML = '<option value="">Loading...</option>';
        
        {{--
            FETCH REQUEST: Mengambil data tagihan santri
            
            URL: /admin/pembayaran/tagihan/{santriId}
            Method: GET (default)
            Response: Array JSON berisi objek tagihan
            
            Struktur response yang diharapkan:
            [
                { id: 1, nama_tagihan: "SPP Januari", total_bayar: 1500000 },
                { id: 2, nama_tagihan: "SPP Februari", total_bayar: 1500000 }
            ]
        --}}
        fetch(`{{ url('admin/pembayaran/tagihan') }}/${santriId}`)
            .then(response => response.json())
            .then(data => {
                {{-- Buat option default --}}
                let options = '<option value="">Pilih Tagihan</option>';
                {{--
                    Looping data tagihan dan buat option untuk masing-masing
                    
                    data-total: Custom data attribute untuk menyimpan nilai tagihan
                    Number(t.total_bayar).toLocaleString('id-ID'):
                    - Format angka ke format lokal Indonesia
                    - Contoh: 1500000 menjadi "1.500.000"
                --}}
                data.forEach(t => {
                    options += `<option value="${t.id}" data-total="${t.total_bayar}">${t.nama_tagihan} - Rp ${Number(t.total_bayar).toLocaleString('id-ID')}</option>`;
                });
                {{-- Render options ke dropdown --}}
                tagihanSelect.innerHTML = options;
            })
            .catch(err => {
                {{-- Handle error: Tampilkan pesan error di dropdown --}}
                tagihanSelect.innerHTML = '<option value="">Error loading</option>';
            });
    });
    
    {{--
        EVENT LISTENER 2: PERUBAHAN PEMILIHAN TAGIHAN
        
        Ketika admin memilih tagihan:
        1. Ambil option yang sedang dipilih
        2. Ambil nilai dari data-total attribute
        3. Set value input jumlah_bayar dengan nilai tagihan
        
        FITUR: Autofill jumlah bayar sesuai nominal tagihan
    --}}
    document.getElementById('tagihan_id').addEventListener('change', function() {
        {{-- Ambil option yang sedang selected --}}
        const selected = this.options[this.selectedIndex];
        {{-- Ambil nilai dari data-total attribute, default 0 jika tidak ada --}}
        const total = selected.dataset.total || 0;
        {{-- Set value ke input jumlah bayar --}}
        document.getElementById('jumlah_bayar').value = total;
    });
</script>
@endpush
