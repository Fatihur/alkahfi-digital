<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Pengumuman;
use App\Models\Tagihan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $santriIds = $user->waliSantri()->pluck('santri_id');

        $tagihanBelumBayar = Tagihan::whereIn('santri_id', $santriIds)
            ->whereIn('status', ['belum_bayar', 'jatuh_tempo'])
            ->with('santri')
            ->get();

        $totalTagihan = $tagihanBelumBayar->sum('total_bayar');

        $pengumumanTerbaru = Pengumuman::published()
            ->aktif()
            ->latest()
            ->take(5)
            ->get();

        $kegiatanMendatang = Kegiatan::published()
            ->akanDatang()
            ->orderBy('tanggal_pelaksanaan')
            ->take(5)
            ->get();

        return view('wali.dashboard', compact(
            'tagihanBelumBayar',
            'totalTagihan',
            'pengumumanTerbaru',
            'kegiatanMendatang'
        ));
    }
}
