<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTagihanBelumBayar = Tagihan::where('status', 'belum_bayar')->sum('total_bayar');
        $totalPembayaranHariIni = Pembayaran::where('status', 'berhasil')
            ->whereDate('tanggal_bayar', today())
            ->sum('jumlah_bayar');
        $totalPembayaranBulanIni = Pembayaran::where('status', 'berhasil')
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('jumlah_bayar');

        $tagihanJatuhTempo = Tagihan::where('status', 'belum_bayar')
            ->where('tanggal_jatuh_tempo', '<=', now())
            ->count();

        $pembayaranTerbaru = Pembayaran::with(['santri', 'tagihan'])
            ->where('status', 'berhasil')
            ->latest('tanggal_bayar')
            ->take(10)
            ->get();

        return view('bendahara.dashboard', compact(
            'totalTagihanBelumBayar',
            'totalPembayaranHariIni',
            'totalPembayaranBulanIni',
            'tagihanJatuhTempo',
            'pembayaranTerbaru'
        ));
    }
}
