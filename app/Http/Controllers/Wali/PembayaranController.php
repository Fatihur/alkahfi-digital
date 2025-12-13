<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Services\DuitkuService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected DuitkuService $duitkuService;

    public function __construct(DuitkuService $duitkuService)
    {
        $this->duitkuService = $duitkuService;
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

        $pembayaran = $query->latest()->get();

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

        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $pembayaran = Pembayaran::create([
            'nomor_transaksi' => Pembayaran::generateNomorTransaksi(),
            'tagihan_id' => $tagihan->id,
            'santri_id' => $tagihan->santri_id,
            'jumlah_bayar' => $tagihan->total_bayar,
            'metode_pembayaran' => 'payment_gateway',
            'channel_pembayaran' => $request->payment_method,
            'status' => 'pending',
        ]);

        $tagihan->update(['status' => 'pending']);

        try {
            $result = $this->duitkuService->createTransaction($pembayaran, $request->payment_method);
            
            if (!empty($result['payment_url'])) {
                return redirect()->away($result['payment_url']);
            }
            
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

        // Auto-verify status jika masih pending
        if ($pembayaran->status === 'pending') {
            try {
                $this->duitkuService->verifyPayment($pembayaran);
                $pembayaran->refresh();
            } catch (\Exception $e) {
                // Ignore error, continue showing checkout page
            }
        }

        if ($pembayaran->status === 'berhasil') {
            return redirect()->route('wali.pembayaran.show', $pembayaran->id)
                ->with('success', 'Pembayaran berhasil!');
        }

        $pembayaran->load(['santri', 'tagihan']);
        $gatewayResponse = $pembayaran->gateway_response ?? [];

        return view('wali.pembayaran.checkout', compact('pembayaran', 'gatewayResponse'));
    }

    public function konfirmasi(Pembayaran $pembayaran)
    {
        $this->authorizePembayaran($pembayaran);

        $pembayaran->load(['santri', 'tagihan']);
        return view('wali.pembayaran.konfirmasi', compact('pembayaran'));
    }

    public function paymentReturn(Pembayaran $pembayaran)
    {
        $this->authorizePembayaran($pembayaran);

        // Auto-verify status dari payment gateway
        if ($pembayaran->status === 'pending') {
            try {
                $this->duitkuService->verifyPayment($pembayaran);
                $pembayaran->refresh();
            } catch (\Exception $e) {
                // Ignore error
            }
        }

        if ($pembayaran->status === 'berhasil') {
            return redirect()->route('wali.pembayaran.show', $pembayaran->id)
                ->with('success', 'Pembayaran berhasil! Terima kasih.');
        }

        return redirect()->route('wali.pembayaran.checkout', $pembayaran->id);
    }

    public function verify(Pembayaran $pembayaran)
    {
        $this->authorizePembayaran($pembayaran);

        try {
            $result = $this->duitkuService->verifyPayment($pembayaran);
            
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
