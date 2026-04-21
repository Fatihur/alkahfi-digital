<?php

// =====================================================
// FILE: SantriController.php
// DESKRIPSI: Controller untuk mengelola data santri
//            (CRUD: Create, Read, Update, Delete)
// LOKASI: app/Http/Controllers/Admin/SantriController.php
// ROUTE: /admin/santri/* (didefinisikan di routes/web.php)
// =====================================================

namespace App\Http\Controllers\Admin;

// Import class Controller dari namespace induk
use App\Http\Controllers\Controller;

// Import Model yang dibutuhkan untuk operasi database
use App\Models\Jurusan;      // Model untuk data jurusan
use App\Models\Kelas;        // Model untuk data kelas
use App\Models\LogAktivitas; // Model untuk mencatat log aktivitas
use App\Models\Santri;       // Model utama untuk data santri
use App\Models\User;         // Model untuk data user/wali santri
use App\Models\WaliSantri;   // Model untuk relasi wali-santri

// Import Request untuk validasi input
use Illuminate\Http\Request;

// Import Storage untuk operasi file (upload foto)
use Illuminate\Support\Facades\Storage;

/**
 * Class SantriController
 * 
 * Controller ini menangani semua operasi terkait data santri:
 * - index: Menampilkan daftar santri dengan filter
 * - create: Menampilkan form tambah santri
 * - store: Menyimpan data santri baru
 * - show: Menampilkan detail santri
 * - edit: Menampilkan form edit santri
 * - update: Memperbarui data santri
 * - destroy: Menghapus data santri
 */
class SantriController extends Controller
{
    /**
     * Method index() - Menampilkan daftar santri
     * 
     * URL: GET /admin/santri
     * Return: View dengan data santri dan filter
     * 
     * Fitur:
     * - Pagination dengan filter
     * - Search berdasarkan nama atau NIS
     * - Filter berdasarkan kelas dan status
     * 
     * @param Request $request - Object berisi query parameter (search, kelas_id, status)
     */
    public function index(Request $request)
    {
        // =====================================================
        // BAGIAN 1: QUERY DASAR DENGAN EAGER LOADING
        // =====================================================
        
        // Memulai query builder untuk model Santri
        // with(['kelas', 'jurusan']) = Eager Loading untuk mengurangi query N+1
        // Tanpa eager loading: 1 query santri + N query kelas + N query jurusan
        // Dengan eager loading: 1 query santri + 1 query kelas + 1 query jurusan
        $query = Santri::with(['kelas', 'jurusan']);

        // =====================================================
        // BAGIAN 2: FILTER PENCARIAN (SEARCH)
        // =====================================================
        
        // Cek apakah parameter 'search' ada dan tidak kosong
        // filled() = cek ada dan tidak empty/null
        if ($request->filled('search')) {
            // Ambil nilai search dari request
            $search = $request->search;
            
            // where(function ($q) {...}) = grup kondisi OR
            // like "%{$search}%" = pencarian partial (contains)
            // Contoh: search "Ahmad" akan menemukan "Ahmad Fauzi", "Syahrul Ahmad"
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // =====================================================
        // BAGIAN 3: FILTER BERDASARKAN KELAS
        // =====================================================
        
        // Filter jika parameter kelas_id ada
        // where('kelas_id', $request->kelas_id) = filter santri di kelas tertentu
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // =====================================================
        // BAGIAN 4: FILTER BERDASARKAN STATUS
        // =====================================================
        
        // Filter jika parameter status ada
        // Status bisa: aktif, nonaktif, lulus, pindah
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // =====================================================
        // BAGIAN 5: EKSEKUSI QUERY
        // =====================================================
        
        // latest() = urutkan berdasarkan created_at DESC (terbaru dulu)
        // get() = ambil semua hasil sebagai Collection
        // Contoh alternatif: paginate(10) untuk pagination
        $santri = $query->latest()->get();
        
        // Ambil daftar kelas aktif untuk dropdown filter
        // where('is_active', true) = hanya kelas yang aktif
        $kelasList = Kelas::where('is_active', true)->get();

        // =====================================================
        // BAGIAN 6: RETURN VIEW
        // =====================================================
        
        // Kirim data ke view: santri (hasil query) dan kelasList (dropdown)
        return view('admin.santri.index', compact('santri', 'kelasList'));
    }

    /**
     * Method create() - Menampilkan form tambah santri
     * 
     * URL: GET /admin/santri/create
     * Return: View form dengan data dropdown
     * 
     * Mengambil data untuk dropdown:
     * - Daftar kelas aktif
     * - Daftar jurusan aktif
     * - Daftar wali santri aktif
     */
    public function create()
    {
        // Ambil daftar kelas aktif untuk dropdown
        $kelasList = Kelas::where('is_active', true)->get();
        
        // Ambil daftar jurusan aktif untuk dropdown
        $jurusanList = Jurusan::where('is_active', true)->get();
        
        // Ambil daftar user dengan role 'wali_santri' yang aktif
        // untuk dropdown pemilihan wali santri
        $waliList = User::where('role', 'wali_santri')->where('is_active', true)->get();

        // Kirim semua data ke view form
        return view('admin.santri.create', compact('kelasList', 'jurusanList', 'waliList'));
    }

    /**
     * Method store() - Menyimpan data santri baru
     * 
     * URL: POST /admin/santri
     * Return: Redirect ke index dengan pesan sukses
     * 
     * Proses:
     * 1. Validasi input
     * 2. Upload foto jika ada
     * 3. Simpan data santri
     * 4. Simpan relasi wali santri jika dipilih
     * 5. Catat log aktivitas
     */
    public function store(Request $request)
    {
        // =====================================================
        // BAGIAN 1: VALIDASI INPUT
        // =====================================================
        
        // $request->validate([]) = validasi input dari form
        // Aturan validasi:
        // - required: wajib diisi
        // - string: harus berupa string
        // - max:N: maksimal N karakter
        // - unique:santri: harus unik di tabel santri
        // - in:L,P: hanya boleh L atau P
        // - nullable: boleh kosong
        // - date: harus format tanggal
        // - exists:kelas,id: harus ada di tabel kelas kolom id
        // - image: harus berupa gambar
        // - max:2048: maksimal 2MB
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:20', 'unique:santri'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],  // L=Laki-laki, P=Perempuan
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'jurusan_id' => ['nullable', 'exists:jurusan,id'],
            'tanggal_masuk' => ['nullable', 'date'],
            'foto' => ['nullable', 'image', 'max:2048'],  // Maksimal 2MB
            'status' => ['required', 'in:aktif,nonaktif,lulus,pindah'],
            'wali_id' => ['nullable', 'exists:users,id'],
            'hubungan' => ['nullable', 'in:ayah,ibu,wali'],
        ]);

        // =====================================================
        // BAGIAN 2: UPLOAD FOTO
        // =====================================================
        
        // Cek apakah ada file foto diupload
        // hasFile('foto') = cek apakah input file dengan name='foto' ada
        if ($request->hasFile('foto')) {
            // store('santri', 'public') = simpan file ke storage/app/public/santri
            // Return: path file (contoh: "santri/filename.jpg")
            // 'public' = menggunakan disk public (storage/app/public)
            $validated['foto'] = $request->file('foto')->store('santri', 'public');
        }

        // =====================================================
        // BAGIAN 3: SIMPAN DATA SANTRI
        // =====================================================
        
        // Hapus field wali_id dan hubungan dari validated
        // Karena akan disimpan di tabel terpisah (wali_santri)
        unset($validated['wali_id'], $validated['hubungan']);
        
        // Santri::create($validated) = insert data ke tabel santri
        // Return: Instance model Santri yang baru dibuat
        $santri = Santri::create($validated);

        // =====================================================
        // BAGIAN 4: SIMPAN RELASI WALI SANTRI
        // =====================================================
        
        // Cek apakah wali_id dipilih (tidak kosong)
        // filled() = cek ada dan tidak kosong
        if ($request->filled('wali_id')) {
            // Buat relasi di tabel wali_santri
            WaliSantri::create([
                'user_id' => $request->wali_id,      // ID user wali
                'santri_id' => $santri->id,          // ID santri baru
                'hubungan' => $request->hubungan ?? 'wali',  // Default: wali
            ]);
        }

        // =====================================================
        // BAGIAN 5: CATAT LOG AKTIVITAS
        // =====================================================
        
        // Mencatat aktivitas untuk audit trail
        // Parameter: aksi, tabel, deskripsi, data_lama, data_baru
        LogAktivitas::log('Tambah Santri', 'santri', "Menambahkan santri: {$santri->nama_lengkap}", null, $santri->toArray());

        // =====================================================
        // BAGIAN 6: REDIRECT DENGAN PESAN
        // =====================================================
        
        // Redirect ke halaman index dengan pesan sukses
        // with('success', '...') = flash message yang tampil sekali
        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil ditambahkan.');
    }

    /**
     * Method show() - Menampilkan detail santri
     * 
     * URL: GET /admin/santri/{santri}
     * Parameter: $santri - Model binding, otomatis find by ID
     * Return: View detail dengan data lengkap
     * 
     * Menggunakan Route Model Binding:
     * Laravel otomatis mencari Santri dengan ID dari URL
     * Contoh: /admin/santri/5 => $santri = Santri::find(5)
     */
    public function show(Santri $santri)
    {
        // load([]) = Lazy Eager Loading, load relasi setelah model ada
        // Sama dengan with() tapi untuk instance yang sudah ada
        $santri->load(['kelas', 'jurusan', 'wali', 'tagihan', 'pembayaran']);
        
        // Kirim data santri lengkap ke view
        return view('admin.santri.show', compact('santri'));
    }

    /**
     * Method edit() - Menampilkan form edit santri
     * 
     * URL: GET /admin/santri/{santri}/edit
     * Return: View form dengan data santri yang akan diedit
     */
    public function edit(Santri $santri)
    {
        // Ambil data untuk dropdown (sama seperti create)
        $kelasList = Kelas::where('is_active', true)->get();
        $jurusanList = Jurusan::where('is_active', true)->get();
        $waliList = User::where('role', 'wali_santri')->where('is_active', true)->get();
        
        // Load relasi wali untuk menampilkan wali yang sudah dipilih
        $santri->load('wali');

        // Kirim data santri + dropdown ke view
        return view('admin.santri.edit', compact('santri', 'kelasList', 'jurusanList', 'waliList'));
    }

    /**
     * Method update() - Memperbarui data santri
     * 
     * URL: PUT/PATCH /admin/santri/{santri}
     * Return: Redirect ke index dengan pesan sukses
     */
    public function update(Request $request, Santri $santri)
    {
        // =====================================================
        // BAGIAN 1: VALIDASI INPUT
        // =====================================================
        
        // Validasi mirip dengan store(), tapi dengan pengecualian unique
        // unique:santri,nis,' . $santri->id = abaikan record dengan ID ini
        // Artinya: NIS harus unik, kecuali untuk santri yang sedang diedit
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:20', 'unique:santri,nis,' . $santri->id],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'jurusan_id' => ['nullable', 'exists:jurusan,id'],
            'tanggal_masuk' => ['nullable', 'date'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:aktif,nonaktif,lulus,pindah'],
        ]);

        // =====================================================
        // BAGIAN 2: SIMPAN DATA LAMA UNTUK LOG
        // =====================================================
        
        // Simpan data lama sebelum update untuk perbandingan di log
        $oldData = $santri->toArray();

        // =====================================================
        // BAGIAN 3: UPLOAD FOTO BARU (JIKA ADA)
        // =====================================================
        
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            // Storage::disk('public') = akses disk public
            // delete($santri->foto) = hapus file berdasarkan path
            if ($santri->foto) {
                Storage::disk('public')->delete($santri->foto);
            }
            // Simpan foto baru
            $validated['foto'] = $request->file('foto')->store('santri', 'public');
        }

        // =====================================================
        // BAGIAN 4: UPDATE DATA
        // =====================================================
        
        // Update data santri dengan data yang sudah divalidasi
        $santri->update($validated);

        // =====================================================
        // BAGIAN 5: CATAT LOG AKTIVITAS
        // =====================================================
        
        // fresh() = ambil ulang data dari database untuk memastikan data terbaru
        LogAktivitas::log('Update Santri', 'santri', "Mengupdate santri: {$santri->nama_lengkap}", $oldData, $santri->fresh()->toArray());

        // Redirect dengan pesan sukses
        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil diupdate.');
    }

    /**
     * Method destroy() - Menghapus data santri
     * 
     * URL: DELETE /admin/santri/{santri}
     * Return: Redirect ke index dengan pesan sukses
     * 
     * Catatan: Soft Delete lebih direkomendasikan untuk data penting
     * sehingga data masih bisa dikembalikan jika diperlukan
     */
    public function destroy(Santri $santri)
    {
        // Catat log sebelum menghapus (karena setelah hapus data tidak ada)
        LogAktivitas::log('Hapus Santri', 'santri', "Menghapus santri: {$santri->nama_lengkap}", $santri->toArray());

        // Hapus foto jika ada
        if ($santri->foto) {
            Storage::disk('public')->delete($santri->foto);
        }

        // Hapus data santri dari database
        // Jika menggunakan Soft Deletes, ini akan mengisi deleted_at
        $santri->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri berhasil dihapus.');
    }
}
