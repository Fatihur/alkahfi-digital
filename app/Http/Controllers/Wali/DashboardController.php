<?php

// =====================================================
// FILE: DashboardController.php (Wali)
// DESKRIPSI: Controller untuk dashboard Wali Santri
//            Menampilkan tagihan, pengumuman, dan kegiatan
// LOKASI: app/Http/Controllers/Wali/DashboardController.php
// ROUTE: GET /wali/dashboard
// =====================================================

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;     // Model untuk data kegiatan
use App\Models\Pengumuman;   // Model untuk data pengumuman
use App\Models\Tagihan;      // Model untuk data tagihan

/**
 * Class DashboardController
 * 
 * Menangani tampilan dashboard untuk wali santri
 * Wali santri bisa melihat:
 * - Tagihan anak-anak yang menjadi tanggungannya
 * - Pengumuman terbaru dari sekolah
 * - Kegiatan yang akan datang
 */
class DashboardController extends Controller
{
    /**
     * Method index() - Halaman Dashboard Wali Santri
     * 
     * URL: GET /wali/dashboard
     * Return: View dengan data tagihan, pengumuman, dan kegiatan
     * 
     * Alur:
     * 1. Ambil user yang sedang login
     * 2. Ambil ID santri yang menjadi tanggungan wali ini
     * 3. Ambil tagihan yang belum dibayar
     * 4. Hitung total tagihan
     * 5. Ambil pengumuman terbaru
     * 6. Ambil kegiatan mendatang
     */
    public function index()
    {
        // =====================================================
        // BAGIAN 1: AMBIL DATA USER DAN SANTRI
        // =====================================================
        
        // Ambil user yang sedang login (wali santri)
        $user = auth()->user();
        
        // Ambil semua santri_id yang terhubung dengan wali ini
        // waliSantri() = relasi hasMany di Model User
        // pluck('santri_id') = ambil hanya kolom santri_id sebagai array
        // Contoh hasil: [1, 5, 8] (wali punya 3 anak santri)
        $santriIds = $user->waliSantri()->pluck('santri_id');

        // =====================================================
        // BAGIAN 2: AMBIL TAGIHAN BELUM BAYAR
        // =====================================================
        
        // Query tagihan untuk santri-santri yang ditanggung wali
        // whereIn('santri_id', $santriIds): Filter berdasarkan array ID santri
        // whereIn('status', [...]): Filter status belum_bayar atau jatuh_tempo
        // with('santri'): Eager loading data santri untuk optimasi query
        $tagihanBelumBayar = Tagihan::whereIn('santri_id', $santriIds)
            ->whereIn('status', ['belum_bayar', 'jatuh_tempo'])
            ->with('santri')
            ->get();

        // =====================================================
        // BAGIAN 3: HITUNG TOTAL TAGIHAN
        // =====================================================
        
        // sum('total_bayar'): Menjumlahkan kolom total_bayar dari collection
        // Menggunakan method collection, bukan query builder
        // Contoh: 3 tagihan (500rb + 750rb + 300rb) = 1.550.000
        $totalTagihan = $tagihanBelumBayar->sum('total_bayar');

        // =====================================================
        // BAGIAN 4: AMBIL PENGUMUMAN TERBARU
        // =====================================================
        
        // Ambil 5 pengumuman terbaru yang aktif
        // published(): Scope untuk pengumuman yang sudah dipublish
        // aktif(): Scope untuk pengumuman yang masih aktif (belum expired)
        // latest(): Urutkan berdasarkan created_at DESC
        $pengumumanTerbaru = Pengumuman::published()
            ->aktif()
            ->latest()
            ->take(5)
            ->get();

        // =====================================================
        // BAGIAN 5: AMBIL KEGIATAN MENDATANG
        // =====================================================
        
        // Ambil 5 kegiatan yang akan datang
        // published(): Scope untuk kegiatan yang sudah dipublish
        // akanDatang(): Scope untuk kegiatan dengan tanggal > hari ini
        // orderBy('tanggal_pelaksanaan'): Urutkan dari tanggal terdekat
        $kegiatanMendatang = Kegiatan::published()
            ->akanDatang()
            ->orderBy('tanggal_pelaksanaan')
            ->take(5)
            ->get();

        // =====================================================
        // BAGIAN 6: RETURN VIEW
        // =====================================================
        
        // Kirim data ke view wali/dashboard.blade.php
        return view('wali.dashboard', compact(
            'tagihanBelumBayar',  // Collection tagihan yang belum bayar
            'totalTagihan',       // Total nominal tagihan (integer)
            'pengumumanTerbaru',  // Collection pengumuman
            'kegiatanMendatang'   // Collection kegiatan
        ));
    }
}
