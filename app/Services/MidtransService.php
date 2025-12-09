<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createTransaction(Pembayaran $pembayaran): array
    {
        $tagihan = $pembayaran->tagihan;
        $santri = $pembayaran->santri;

        $params = [
            'transaction_details' => [
                'order_id' => $pembayaran->nomor_transaksi,
                'gross_amount' => (int) $pembayaran->jumlah_bayar,
            ],
            'customer_details' => [
                'first_name' => $santri->nama_lengkap,
                'email' => $santri->wali->first()?->email ?? 'noemail@alkahfi.digital',
                'phone' => $santri->wali->first()?->no_hp ?? '',
            ],
            'item_details' => [
                [
                    'id' => $tagihan->id,
                    'price' => (int) $pembayaran->jumlah_bayar,
                    'quantity' => 1,
                    'name' => substr($tagihan->nama_tagihan . ' - ' . $santri->nama_lengkap, 0, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('wali.pembayaran.index'),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $snapUrl = 'https://app.' . (config('midtrans.is_production') ? '' : 'sandbox.') . 'midtrans.com/snap/v2/vtweb/' . $snapToken;

        $pembayaran->update([
            'transaction_id' => $pembayaran->nomor_transaksi,
            'payment_url' => $snapUrl,
            'gateway_response' => ['snap_token' => $snapToken],
        ]);

        return [
            'snap_token' => $snapToken,
            'snap_url' => $snapUrl,
        ];
    }

    public function handleNotification(): array
    {
        $notification = new Notification();

        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status ?? null;
        $paymentType = $notification->payment_type;

        $pembayaran = Pembayaran::where('nomor_transaksi', $orderId)->first();

        if (!$pembayaran) {
            return ['status' => 'error', 'message' => 'Pembayaran tidak ditemukan'];
        }

        $pembayaran->update([
            'gateway_response' => (array) $notification,
            'channel_pembayaran' => $paymentType,
        ]);

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $this->setPaymentSuccess($pembayaran);
            } elseif ($fraudStatus == 'challenge') {
                $pembayaran->update(['status' => 'pending']);
            }
        } elseif ($transactionStatus == 'settlement') {
            $this->setPaymentSuccess($pembayaran);
        } elseif ($transactionStatus == 'pending') {
            $pembayaran->update(['status' => 'pending']);
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $this->setPaymentFailed($pembayaran, $transactionStatus);
        }

        return [
            'status' => 'success',
            'transaction_status' => $transactionStatus,
            'order_id' => $orderId,
        ];
    }

    protected function setPaymentSuccess(Pembayaran $pembayaran): void
    {
        $pembayaran->update([
            'status' => 'berhasil',
            'tanggal_bayar' => now(),
        ]);

        $pembayaran->tagihan->update([
            'status' => 'lunas',
        ]);

        $this->sendNotificationToWali($pembayaran, 'success');
    }

    protected function setPaymentFailed(Pembayaran $pembayaran, string $status): void
    {
        $pembayaran->update([
            'status' => $status == 'expire' ? 'expired' : 'gagal',
        ]);

        $pembayaran->tagihan->update([
            'status' => 'belum_bayar',
        ]);
    }

    protected function sendNotificationToWali(Pembayaran $pembayaran, string $type): void
    {
        $santri = $pembayaran->santri;

        foreach ($santri->wali as $wali) {
            \App\Models\Notifikasi::create([
                'user_id' => $wali->id,
                'judul' => $type == 'success' ? 'Pembayaran Berhasil' : 'Pembayaran Gagal',
                'pesan' => $type == 'success'
                    ? "Pembayaran untuk {$pembayaran->tagihan->nama_tagihan} sebesar Rp " . number_format($pembayaran->jumlah_bayar, 0, ',', '.') . " telah berhasil."
                    : "Pembayaran untuk {$pembayaran->tagihan->nama_tagihan} gagal diproses.",
                'tipe' => 'pembayaran',
                'link' => route('wali.pembayaran.show', $pembayaran->id),
            ]);
        }
    }

    public function verifyPayment(Pembayaran $pembayaran): array
    {
        $status = Transaction::status($pembayaran->nomor_transaksi);

        $transactionStatus = $status->transaction_status ?? null;
        $fraudStatus = $status->fraud_status ?? null;
        $paymentType = $status->payment_type ?? null;

        $pembayaran->update([
            'gateway_response' => (array) $status,
            'channel_pembayaran' => $paymentType,
        ]);

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $this->setPaymentSuccess($pembayaran);
            }
        } elseif ($transactionStatus == 'settlement') {
            $this->setPaymentSuccess($pembayaran);
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $this->setPaymentFailed($pembayaran, $transactionStatus);
        }

        return [
            'status' => $transactionStatus,
            'pembayaran_status' => $pembayaran->fresh()->status,
        ];
    }

    public static function getClientKey(): string
    {
        return config('midtrans.client_key');
    }
}
