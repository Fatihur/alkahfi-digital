<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Santri;
use App\Models\Tagihan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSantri = Santri::where('status', 'aktif')->count();
        $totalWali = User::where('role', 'wali_santri')->where('is_active', true)->count();
        $totalTagihan = Tagihan::where('status', 'belum_bayar')->sum('total_bayar');
        $totalPembayaran = Pembayaran::where('status', 'berhasil')->sum('jumlah_bayar');

        $tagihanBelumBayar = Tagihan::where('status', 'belum_bayar')->count();
        $tagihanLunas = Tagihan::where('status', 'lunas')->count();
        $tagihanJatuhTempo = Tagihan::where('status', 'jatuh_tempo')->count();

        $pembayaranTerbaru = Pembayaran::with(['santri', 'tagihan'])
            ->where('status', 'berhasil')
            ->latest('tanggal_bayar')
            ->take(5)
            ->get();

        $tagihanTerbaru = Tagihan::with(['santri'])
            ->where('status', 'belum_bayar')
            ->orderBy('tanggal_jatuh_tempo')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSantri',
            'totalWali',
            'totalTagihan',
            'totalPembayaran',
            'tagihanBelumBayar',
            'tagihanLunas',
            'tagihanJatuhTempo',
            'pembayaranTerbaru',
            'tagihanTerbaru'
        ));
    }
}
