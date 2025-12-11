<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\Notifikasi;
use App\Models\Pembayaran;
use App\Models\Santri;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['santri', 'tagihan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('santri', function ($sq) use ($search) {
                      $sq->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_bayar', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_bayar', '<=', $request->tanggal_sampai);
        }

        $pembayaran = $query->latest()->get();

        return view('bendahara.pembayaran.index', compact('pembayaran'));
    }

    public function create()
    {
        $santriList = Santri::where('status', 'aktif')
            ->whereHas('tagihan', function ($q) {
                $q->where('status', 'belum_bayar');
            })
            ->get();

        return view('bendahara.pembayaran.create', compact('santriList'));
    }

    public function getTagihanBySantri(Santri $santri)
    {
        $tagihan = $santri->tagihan()
            ->where('status', 'belum_bayar')
            ->get();

        return response()->json($tagihan);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => ['required', 'exists:santri,id'],
            'tagihan_id' => ['required', 'exists:tagihan,id'],
            'jumlah_bayar' => ['required', 'numeric', 'min:0'],
            'metode_pembayaran' => ['required', 'in:tunai,transfer'],
            'tanggal_bayar' => ['required', 'date'],
            'catatan' => ['nullable', 'string'],
        ]);

        $tagihan = Tagihan::findOrFail($request->tagihan_id);

        if ($tagihan->status === 'lunas') {
            return back()->with('error', 'Tagihan sudah lunas.');
        }

        $pembayaran = Pembayaran::create([
            'nomor_transaksi' => Pembayaran::generateNomorTransaksi(),
            'tagihan_id' => $tagihan->id,
            'santri_id' => $request->santri_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'berhasil',
            'tanggal_bayar' => $request->tanggal_bayar,
            'catatan' => $request->catatan,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        $tagihan->update(['status' => 'lunas']);

        $santri = Santri::find($request->santri_id);
        foreach ($santri->wali as $wali) {
            Notifikasi::create([
                'user_id' => $wali->id,
                'judul' => 'Pembayaran Berhasil',
                'pesan' => "Pembayaran untuk {$tagihan->nama_tagihan} telah berhasil.",
                'tipe' => 'pembayaran',
                'link' => route('wali.pembayaran.show', $pembayaran->id),
            ]);
        }

        LogAktivitas::log('Pembayaran Manual', 'pembayaran', "Pembayaran manual untuk tagihan: {$tagihan->nama_tagihan}");

        return redirect()->route('bendahara.pembayaran.index')
            ->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['santri', 'tagihan', 'verifiedBy']);
        return view('bendahara.pembayaran.show', compact('pembayaran'));
    }

    public function cetakBukti(Pembayaran $pembayaran)
    {
        $pembayaran->load(['santri', 'tagihan']);
        return view('bendahara.pembayaran.cetak', compact('pembayaran'));
    }
}
