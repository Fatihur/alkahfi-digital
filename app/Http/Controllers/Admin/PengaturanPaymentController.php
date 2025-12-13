<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PengaturanPaymentController extends Controller
{
    public function index()
    {
        $settings = [
            'duitku_merchant_code' => Pengaturan::get('duitku_merchant_code', ''),
            'duitku_api_key' => Pengaturan::get('duitku_api_key', ''),
            'duitku_is_production' => Pengaturan::get('duitku_is_production', '0'),
            'duitku_callback_url' => Pengaturan::get('duitku_callback_url', ''),
            'duitku_return_url' => Pengaturan::get('duitku_return_url', ''),
            'duitku_expiry_period' => Pengaturan::get('duitku_expiry_period', '1440'),
            'payment_gateway_enabled' => Pengaturan::get('payment_gateway_enabled', '1'),
        ];

        return view('admin.pengaturan.payment', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'duitku_merchant_code' => 'nullable|string|max:50',
            'duitku_api_key' => 'nullable|string|max:100',
            'duitku_is_production' => 'required|in:0,1',
            'duitku_callback_url' => 'nullable|string|max:255',
            'duitku_return_url' => 'nullable|string|max:255',
            'duitku_expiry_period' => 'required|integer|min:60|max:10080',
            'payment_gateway_enabled' => 'required|in:0,1',
        ]);

        foreach ($validated as $key => $value) {
            Pengaturan::set($key, $value ?? '', 'payment');
        }

        // Clear config cache
        Artisan::call('config:clear');

        return back()->with('success', 'Pengaturan payment gateway berhasil disimpan.');
    }

    public function testConnection()
    {
        try {
            $merchantCode = Pengaturan::get('duitku_merchant_code', '');
            $apiKey = Pengaturan::get('duitku_api_key', '');
            $isProduction = Pengaturan::get('duitku_is_production', '0') === '1';

            if (empty($merchantCode) || empty($apiKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Merchant Code dan API Key harus diisi terlebih dahulu.',
                ]);
            }

            $baseUrl = $isProduction
                ? 'https://passport.duitku.com/webapi/api/merchant'
                : 'https://sandbox.duitku.com/webapi/api/merchant';

            $datetime = date('Y-m-d H:i:s');
            $amount = 10000;
            $signature = hash('sha256', $merchantCode . $amount . $datetime . $apiKey);

            $response = \Illuminate\Support\Facades\Http::timeout(10)->post($baseUrl . '/paymentmethod/getpaymentmethod', [
                'merchantcode' => $merchantCode,
                'amount' => $amount,
                'datetime' => $datetime,
                'signature' => $signature,
            ]);

            if ($response->successful() && isset($response->json()['paymentFee'])) {
                return response()->json([
                    'success' => true,
                    'message' => 'Koneksi ke Duitku berhasil! Ditemukan ' . count($response->json()['paymentFee']) . ' metode pembayaran.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal terhubung ke Duitku: ' . ($response->json()['Message'] ?? 'Unknown error'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
}
