<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DuitkuService
{
    protected string $merchantCode;
    protected string $apiKey;
    protected bool $isProduction;
    protected string $baseUrl;

    public function __construct()
    {
        // Prioritas: Database > Config > Empty
        $this->merchantCode = Pengaturan::get('duitku_merchant_code') ?: config('duitku.merchant_code', '');
        $this->apiKey = Pengaturan::get('duitku_api_key') ?: config('duitku.api_key', '');
        $this->isProduction = (Pengaturan::get('duitku_is_production', '0') === '1') ?: config('duitku.is_production', false);
        $this->baseUrl = $this->isProduction
            ? 'https://passport.duitku.com/webapi/api/merchant'
            : 'https://sandbox.duitku.com/webapi/api/merchant';
    }

    public function getPaymentMethods(int $amount): array
    {
        $datetime = date('Y-m-d H:i:s');
        $signature = hash('sha256', $this->merchantCode . $amount . $datetime . $this->apiKey);

        $response = Http::post($this->baseUrl . '/paymentmethod/getpaymentmethod', [
            'merchantcode' => $this->merchantCode,
            'amount' => $amount,
            'datetime' => $datetime,
            'signature' => $signature,
        ]);

        if ($response->successful()) {
            return $response->json('paymentFee') ?? [];
        }

        Log::error('Duitku getPaymentMethods error', ['response' => $response->body()]);
        return [];
    }

    public function createTransaction(Pembayaran $pembayaran, string $paymentMethod = 'VC'): array
    {
        $tagihan = $pembayaran->tagihan;
        $santri = $pembayaran->santri;
        $wali = $santri->wali->first();

        $merchantOrderId = $pembayaran->nomor_transaksi;
        $paymentAmount = (int) $pembayaran->jumlah_bayar;
        $productDetails = substr($tagihan->nama_tagihan . ' - ' . $santri->nama_lengkap, 0, 255);
        $email = $wali?->email ?? 'noemail@alkahfi.digital';
        $phoneNumber = $wali?->no_hp ?? '';
        $customerVaName = substr($santri->nama_lengkap, 0, 20);
        $callbackUrl = Pengaturan::get('duitku_callback_url') ?: config('duitku.callback_url') ?: url('/api/duitku/callback');
        $returnUrl = Pengaturan::get('duitku_return_url') ?: config('duitku.return_url') ?: route('wali.pembayaran.index');
        $expiryPeriod = (int) (Pengaturan::get('duitku_expiry_period') ?: config('duitku.expiry_period', 1440));

        $signature = md5($this->merchantCode . $merchantOrderId . $paymentAmount . $this->apiKey);

        $params = [
            'merchantCode' => $this->merchantCode,
            'paymentAmount' => $paymentAmount,
            'paymentMethod' => $paymentMethod,
            'merchantOrderId' => $merchantOrderId,
            'productDetails' => $productDetails,
            'customerVaName' => $customerVaName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'callbackUrl' => $callbackUrl,
            'returnUrl' => $returnUrl,
            'signature' => $signature,
            'expiryPeriod' => $expiryPeriod,
        ];

        $response = Http::post($this->baseUrl . '/v2/inquiry', $params);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['statusCode']) && $data['statusCode'] == '00') {
                $pembayaran->update([
                    'transaction_id' => $data['reference'] ?? $merchantOrderId,
                    'payment_url' => $data['paymentUrl'] ?? null,
                    'channel_pembayaran' => $paymentMethod,
                    'gateway_response' => $data,
                ]);

                return [
                    'success' => true,
                    'payment_url' => $data['paymentUrl'] ?? null,
                    'reference' => $data['reference'] ?? null,
                    'va_number' => $data['vaNumber'] ?? null,
                    'qr_string' => $data['qrString'] ?? null,
                    'amount' => $data['amount'] ?? $paymentAmount,
                ];
            }
        }

        Log::error('Duitku createTransaction error', [
            'params' => $params,
            'response' => $response->body(),
        ]);

        throw new \Exception($response->json('Message') ?? 'Gagal membuat transaksi pembayaran');
    }

    public function handleCallback(array $data): array
    {
        $merchantCode = $data['merchantCode'] ?? '';
        $amount = $data['amount'] ?? '';
        $merchantOrderId = $data['merchantOrderId'] ?? '';
        $resultCode = $data['resultCode'] ?? '';
        $signature = $data['signature'] ?? '';

        // Verify signature
        $expectedSignature = md5($merchantCode . $amount . $merchantOrderId . $this->apiKey);

        if ($signature !== $expectedSignature) {
            Log::warning('Duitku callback invalid signature', $data);
            return ['status' => 'error', 'message' => 'Invalid signature'];
        }

        $pembayaran = Pembayaran::where('nomor_transaksi', $merchantOrderId)->first();

        if (!$pembayaran) {
            return ['status' => 'error', 'message' => 'Pembayaran tidak ditemukan'];
        }

        $pembayaran->update([
            'gateway_response' => $data,
        ]);

        if ($resultCode == '00') {
            // Pembayaran berhasil
            $this->setPaymentSuccess($pembayaran);
        } elseif ($resultCode == '01') {
            // Pembayaran pending
            $pembayaran->update(['status' => 'pending']);
        } else {
            // Pembayaran gagal
            $this->setPaymentFailed($pembayaran, $resultCode);
        }

        return [
            'status' => 'success',
            'result_code' => $resultCode,
            'order_id' => $merchantOrderId,
        ];
    }

    public function checkTransaction(string $merchantOrderId): array
    {
        $signature = md5($this->merchantCode . $merchantOrderId . $this->apiKey);

        $response = Http::post($this->baseUrl . '/transactionStatus', [
            'merchantCode' => $this->merchantCode,
            'merchantOrderId' => $merchantOrderId,
            'signature' => $signature,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Duitku checkTransaction error', ['response' => $response->body()]);
        return [];
    }

    public function verifyPayment(Pembayaran $pembayaran): array
    {
        $status = $this->checkTransaction($pembayaran->nomor_transaksi);

        if (empty($status)) {
            return ['status' => 'error', 'message' => 'Gagal mengecek status transaksi'];
        }

        $pembayaran->update([
            'gateway_response' => $status,
        ]);

        $statusCode = $status['statusCode'] ?? '';

        if ($statusCode == '00') {
            $this->setPaymentSuccess($pembayaran);
        } elseif ($statusCode == '01') {
            $pembayaran->update(['status' => 'pending']);
        } else {
            $this->setPaymentFailed($pembayaran, $statusCode);
        }

        return [
            'status' => $statusCode,
            'pembayaran_status' => $pembayaran->fresh()->status,
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

    protected function setPaymentFailed(Pembayaran $pembayaran, string $statusCode): void
    {
        $status = in_array($statusCode, ['02', 'expired']) ? 'expired' : 'gagal';

        $pembayaran->update([
            'status' => $status,
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

    public static function getPaymentMethodName(string $code): string
    {
        $methods = [
            'VC' => 'Credit Card (Visa/Master)',
            'BC' => 'BCA Virtual Account',
            'M2' => 'Mandiri Virtual Account',
            'VA' => 'Maybank Virtual Account',
            'I1' => 'BNI Virtual Account',
            'B1' => 'CIMB Niaga Virtual Account',
            'BT' => 'Permata Bank Virtual Account',
            'A1' => 'ATM Bersama',
            'AG' => 'Bank Artha Graha',
            'NC' => 'Bank Neo Commerce/BNC',
            'BR' => 'BRIVA',
            'S1' => 'Bank Sahabat Sampoerna',
            'OV' => 'OVO',
            'SA' => 'ShopeePay Apps',
            'LF' => 'LinkAja Apps (Fixed Fee)',
            'LA' => 'LinkAja Apps (Percentage Fee)',
            'DA' => 'DANA',
            'IR' => 'Indomaret',
            'A2' => 'POS Indonesia',
            'FT' => 'Pegadaian',
            'OL' => 'Akulaku',
            'JP' => 'Jenius Pay',
        ];

        return $methods[$code] ?? $code;
    }
}
