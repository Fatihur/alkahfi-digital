<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $santriIds = $user->waliSantri()->pluck('santri_id');

        $query = Pembayaran::whereIn('santri_id', $santriIds)
            ->with(['santri', 'tagihan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pembayaran = $query->latest()->paginate(10);

        return view('wali.pembayaran.index', compact('pembayaran'));
    }

    public function show(Pembayaran $pembayaran)
    {
        $this->authorizePembayaran($pembayaran);

        $pembayaran->load(['santri', 'tagihan']);
        return view('wali.pembayaran.show', compact('pembayaran'));
    }

    public function bayar(Tagihan $tagihan)
    {
        $this->authorizeTagihan($tagihan);

        if ($tagihan->status === 'lunas') {
            return back()->with('error', 'Tagihan sudah lunas.');
        }

        return view('wali.pembayaran.bayar', compact('tagihan'));
    }

    public function prosesBayar(Request $request, Tagihan $tagihan)
    {
        $this->authorizeTagihan($tagihan);

        if ($tagihan->status === 'lunas') {
            return back()->with('error', 'Tagihan sudah lunas.');
        }

        $pembayaran = Pembayaran::create([
            'nomor_transaksi' => Pembayaran::generateNomorTransaksi(),
            'tagihan_id' => $tagihan->id,
            'santri_id' => $tagihan->santri_id,
            'jumlah_bayar' => $tagihan->total_bayar,
            'metode_pembayaran' => 'payment_gateway',
            'channel_pembayaran' => $request->channel ?? 'snap',
            'status' => 'pending',
        ]);

        $tagihan->update(['status' => 'pending']);

        try {
            $snapData = $this->midtransService->createTransaction($pembayaran);
            
            return redirect()->route('wali.pembayaran.checkout', $pembayaran->id);
        } catch (\Exception $e) {
            $pembayaran->update(['status' => 'gagal']);
            $tagihan->update(['status' => 'belum_bayar']);
            
            return back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    public function checkout(Pembayaran $pembayaran)
    {
        $this->authorizePembayaran($pembayaran);

        if ($pembayaran->status !== 'pending') {
            return redirect()->route('wali.pembayaran.show', $pembayaran->id);
        }

        $pembayaran->load(['santri', 'tagihan']);
        $clientKey = MidtransService::getClientKey();
        $snapToken = $pembayaran->gateway_response['snap_token'] ?? null;

        return view('wali.pembayaran.checkout', compact('pembayaran', 'clientKey', 'snapToken'));
    }

    public function konfirmasi(Pembayaran $pembayaran)
    {
        $this->authorizePembayaran($pembayaran);

        $pembayaran->load(['santri', 'tagihan']);
        return view('wali.pembayaran.konfirmasi', compact('pembayaran'));
    }

    public function verify(Pembayaran $pembayaran)
    {
        $this->authorizePembayaran($pembayaran);

        try {
            $result = $this->midtransService->verifyPayment($pembayaran);
            
            return response()->json([
                'success' => true,
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cetakBukti(Pembayaran $pembayaran)
    {
        $this->authorizePembayaran($pembayaran);

        if ($pembayaran->status !== 'berhasil') {
            return back()->with('error', 'Bukti pembayaran hanya tersedia untuk pembayaran yang berhasil.');
        }

        $pembayaran->load(['santri', 'tagihan']);
        return view('wali.pembayaran.cetak', compact('pembayaran'));
    }

    protected function authorizeTagihan(Tagihan $tagihan)
    {
        $user = auth()->user();
        $santriIds = $user->waliSantri()->pluck('santri_id')->toArray();

        if (!in_array($tagihan->santri_id, $santriIds)) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }

    protected function authorizePembayaran(Pembayaran $pembayaran)
    {
        $user = auth()->user();
        $santriIds = $user->waliSantri()->pluck('santri_id')->toArray();

        if (!in_array($pembayaran->santri_id, $santriIds)) {
            abort(403, 'Anda tidak memiliki akses.');
        }
    }
}
