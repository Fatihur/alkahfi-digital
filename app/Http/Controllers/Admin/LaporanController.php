<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Santri;
use App\Models\Tagihan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function transaksi(Request $request)
    {
        $query = Pembayaran::with(['santri', 'tagihan'])
            ->where('status', 'berhasil');

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_bayar', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_bayar', '<=', $request->tanggal_sampai);
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('santri', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        $pembayaran = $query->latest('tanggal_bayar')->get();
        $totalPembayaran = $pembayaran->sum('jumlah_bayar');

        return view('admin.laporan.transaksi', compact('pembayaran', 'totalPembayaran'));
    }

    public function tunggakan(Request $request)
    {
        $query = Tagihan::with(['santri', 'santri.kelas'])
            ->whereIn('status', ['belum_bayar', 'jatuh_tempo']);

        if ($request->filled('kelas_id')) {
            $query->whereHas('santri', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $tagihan = $query->orderBy('tanggal_jatuh_tempo')->get();
        $totalTunggakan = $tagihan->sum('total_bayar');

        return view('admin.laporan.tunggakan', compact('tagihan', 'totalTunggakan'));
    }

    public function rekapitulasi(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $rekapBulanan = [];
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $totalTagihan = Tagihan::where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->sum('total_bayar');

            $totalPembayaran = Pembayaran::whereHas('tagihan', function ($q) use ($tahun, $bulan) {
                $q->where('tahun', $tahun)->where('bulan', $bulan);
            })->where('status', 'berhasil')->sum('jumlah_bayar');

            $rekapBulanan[] = [
                'bulan' => $bulan,
                'nama_bulan' => $this->getNamaBulan($bulan),
                'total_tagihan' => $totalTagihan,
                'total_pembayaran' => $totalPembayaran,
                'selisih' => $totalTagihan - $totalPembayaran,
            ];
        }

        return view('admin.laporan.rekapitulasi', compact('rekapBulanan', 'tahun'));
    }

    protected function getNamaBulan($bulan)
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $namaBulan[$bulan] ?? '';
    }
}
