<?php

// =====================================================
// FILE: DashboardController.php
// DESKRIPSI: Controller untuk halaman dashboard Admin
//            Menampilkan ringkasan data sistem pembayaran
// LOKASI: app/Http/Controllers/Admin/DashboardController.php
// =====================================================

// Mendeklarasikan namespace sesuai lokasi file
// App\Http\Controllers\Admin berarti file ini ada di folder Admin
namespace App\Http\Controllers\Admin;

// Import class Controller dari namespace induk
// 'use' digunakan untuk mengimport class dari namespace lain
use App\Http\Controllers\Controller;

// Import Model yang dibutuhkan
// Model = representasi tabel database dalam bentuk class PHP
use App\Models\Pembayaran;  // Model untuk tabel pembayaran
use App\Models\Santri;      // Model untuk tabel santri
use App\Models\Tagihan;     // Model untuk tabel tagihan
use App\Models\User;        // Model untuk tabel users

/**
 * Class DashboardController
 * 
 * Menangani logic untuk halaman dashboard admin
 * URI: /admin/dashboard (didefinisikan di routes/web.php)
 */
class DashboardController extends Controller
{
    /**
     * Method index() - Halaman Utama Dashboard
     * 
     * Method ini dipanggil ketika user mengakses /admin/dashboard
     * Return: View 'admin.dashboard' dengan data statistik
     * 
     * Cara kerja:
     * 1. Mengambil data dari database menggunakan Model
     * 2. Menghitung statistik (jumlah, total, dll)
     * 3. Mengirim data ke view menggunakan compact()
     */
    public function index()
    {
        // =====================================================
        // BAGIAN 1: STATISTIK UTAMA (Card atas)
        // =====================================================
        
        // Menghitung total santri yang statusnya 'aktif'
        // Sintaks: Model::where('kolom', 'nilai')->count()
        // Hasil: Angka total santri aktif (contoh: 150)
        $totalSantri = Santri::where('status', 'aktif')->count();
        
        // Menghitung total wali santri yang aktif
        // where('role', 'wali_santri') = filter user dengan role wali santri
        // where('is_active', true) = hanya yang akunnya aktif
        $totalWali = User::where('role', 'wali_santri')->where('is_active', true)->count();
        
        // Menghitung total nominal tagihan yang belum dibayar
        // sum('total_bayar') = menjumlahkan kolom total_bayar dari semua record
        // Contoh hasil: 5000000 (5 juta)
        $totalTagihan = Tagihan::where('status', 'belum_bayar')->sum('total_bayar');
        
        // Menghitung total pembayaran yang berhasil/sukses
        // status 'berhasil' = pembayaran sudah dikonfirmasi
        $totalPembayaran = Pembayaran::where('status', 'berhasil')->sum('jumlah_bayar');

        // =====================================================
        // BAGIAN 2: STATISTIK TAGIHAN (Card tengah)
        // =====================================================
        
        // Menghitung jumlah tagihan dengan status 'belum_bayar'
        // count() = menghitung jumlah record (bukan menjumlahkan nilai)
        $tagihanBelumBayar = Tagihan::where('status', 'belum_bayar')->count();
        
        // Menghitung jumlah tagihan yang sudah lunas
        $tagihanLunas = Tagihan::where('status', 'lunas')->count();
        
        // Menghitung jumlah tagihan yang sudah jatuh tempo
        $tagihanJatuhTempo = Tagihan::where('status', 'jatuh_tempo')->count();

        // =====================================================
        // BAGIAN 3: DATA TABEL (5 data terbaru)
        // =====================================================
        
        // Mengambil 5 pembayaran terbaru yang berhasil
        // with(['santri', 'tagihan']) = Eager Loading, mengambil data relasi
        //    - santri: data santri yang melakukan pembayaran
        //    - tagihan: data tagihan yang dibayar
        // where('status', 'berhasil') = hanya pembayaran sukses
        // latest('tanggal_bayar') = urutkan berdasarkan tanggal bayar terbaru
        // take(5) = ambil 5 data saja
        // get() = eksekusi query dan ambil hasilnya
        $pembayaranTerbaru = Pembayaran::with(['santri', 'tagihan'])
            ->where('status', 'berhasil')
            ->latest('tanggal_bayar')
            ->take(5)
            ->get();

        // Mengambil 5 tagihan mendekati jatuh tempo
        // with(['santri']) = mengambil data santri pemilik tagihan
        // orderBy('tanggal_jatuh_tempo') = urutkan dari tanggal terdekat
        $tagihanTerbaru = Tagihan::with(['santri'])
            ->where('status', 'belum_bayar')
            ->orderBy('tanggal_jatuh_tempo')
            ->take(5)
            ->get();

        // =====================================================
        // BAGIAN 4: RETURN VIEW
        // =====================================================
        
        // Mengembalikan view 'admin.dashboard' dengan data
        // view('admin.dashboard') = memanggil file: resources/views/admin/dashboard.blade.php
        // compact() = mengubah variable menjadi array untuk dikirim ke view
        // Contoh: compact('totalSantri') = ['totalSantri' => $totalSantri]
        return view('admin.dashboard', compact(
            'totalSantri',        // Kirim ke view sebagai $totalSantri
            'totalWali',          // Kirim ke view sebagai $totalWali
            'totalTagihan',       // Kirim ke view sebagai $totalTagihan
            'totalPembayaran',    // Kirim ke view sebagai $totalPembayaran
            'tagihanBelumBayar',  // Kirim ke view sebagai $tagihanBelumBayar
            'tagihanLunas',       // Kirim ke view sebagai $tagihanLunas
            'tagihanJatuhTempo',  // Kirim ke view sebagai $tagihanJatuhTempo
            'pembayaranTerbaru',  // Kirim ke view sebagai $pembayaranTerbaru (array)
            'tagihanTerbaru'      // Kirim ke view sebagai $tagihanTerbaru (array)
        ));
    }
}
