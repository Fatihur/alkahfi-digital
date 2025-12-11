<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('bendahara.laporan.index');
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

        if ($request->filled('export')) {
            if ($request->export === 'excel') {
                return $this->exportTransaksiExcel($pembayaran);
            }
            if ($request->export === 'pdf') {
                return $this->exportTransaksiPdf($pembayaran, $totalPembayaran, $request);
            }
        }

        return view('bendahara.laporan.transaksi', compact('pembayaran', 'totalPembayaran'));
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

        if ($request->filled('export') && $request->export === 'pdf') {
            return $this->exportTunggakanPdf($tagihan, $totalTunggakan);
        }

        return view('bendahara.laporan.tunggakan', compact('tagihan', 'totalTunggakan'));
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

        if ($request->filled('export') && $request->export === 'pdf') {
            return $this->exportRekapitulasiPdf($rekapBulanan, $tahun);
        }

        return view('bendahara.laporan.rekapitulasi', compact('rekapBulanan', 'tahun'));
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

    protected function exportTransaksiExcel($pembayaran)
    {
        $filename = 'laporan_transaksi_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($pembayaran) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nomor Transaksi', 'Nama Santri', 'NIS', 'Tagihan', 'Jumlah Bayar', 'Metode', 'Tanggal']);

            foreach ($pembayaran as $index => $p) {
                fputcsv($file, [
                    $index + 1,
                    $p->nomor_transaksi,
                    $p->santri->nama_lengkap,
                    $p->santri->nis,
                    $p->tagihan->nama_tagihan,
                    $p->jumlah_bayar,
                    $p->metode_pembayaran,
                    $p->tanggal_bayar->format('d/m/Y H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    protected function exportTransaksiPdf($pembayaran, $totalPembayaran, $request)
    {
        $tanggalDari = $request->tanggal_dari ? date('d/m/Y', strtotime($request->tanggal_dari)) : '-';
        $tanggalSampai = $request->tanggal_sampai ? date('d/m/Y', strtotime($request->tanggal_sampai)) : '-';

        $pdf = Pdf::loadView('admin.laporan.pdf.transaksi', compact('pembayaran', 'totalPembayaran', 'tanggalDari', 'tanggalSampai'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan_transaksi_' . date('Y-m-d_His') . '.pdf');
    }

    protected function exportTunggakanPdf($tagihan, $totalTunggakan)
    {
        $pdf = Pdf::loadView('admin.laporan.pdf.tunggakan', compact('tagihan', 'totalTunggakan'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan_tunggakan_' . date('Y-m-d_His') . '.pdf');
    }

    protected function exportRekapitulasiPdf($rekapBulanan, $tahun)
    {
        $pdf = Pdf::loadView('admin.laporan.pdf.rekapitulasi', compact('rekapBulanan', 'tahun'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('laporan_rekapitulasi_' . $tahun . '_' . date('Y-m-d_His') . '.pdf');
    }
}
