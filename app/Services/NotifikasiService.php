<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\Tagihan;
use App\Models\User;
use App\Models\WaliSantri;

class NotifikasiService
{
    /**
     * Kirim notifikasi tagihan baru ke wali santri
     */
    public static function notifikasiTagihanBaru(Tagihan $tagihan): void
    {
        $santri = $tagihan->santri;
        $waliIds = WaliSantri::where('santri_id', $santri->id)->pluck('user_id');

        foreach ($waliIds as $userId) {
            Notifikasi::create([
                'user_id' => $userId,
                'judul' => 'Tagihan Baru',
                'pesan' => "Tagihan {$tagihan->nama_tagihan} untuk {$santri->nama_lengkap} sebesar Rp " . number_format($tagihan->total_bayar, 0, ',', '.') . " telah dibuat. Jatuh tempo: " . $tagihan->tanggal_jatuh_tempo->format('d/m/Y'),
                'tipe' => 'tagihan',
                'link' => "/wali/tagihan/{$tagihan->id}",
            ]);
        }
    }

    /**
     * Kirim notifikasi tagihan mendekati jatuh tempo
     */
    public static function notifikasiMendekatiJatuhTempo(Tagihan $tagihan, int $hariSebelum = 3): void
    {
        $santri = $tagihan->santri;
        $waliIds = WaliSantri::where('santri_id', $santri->id)->pluck('user_id');

        foreach ($waliIds as $userId) {
            // Cek apakah sudah ada notifikasi serupa dalam 24 jam terakhir
            $existing = Notifikasi::where('user_id', $userId)
                ->where('tipe', 'tagihan')
                ->where('judul', 'Tagihan Mendekati Jatuh Tempo')
                ->where('pesan', 'like', "%{$tagihan->nama_tagihan}%")
                ->where('created_at', '>=', now()->subDay())
                ->exists();

            if (!$existing) {
                Notifikasi::create([
                    'user_id' => $userId,
                    'judul' => 'Tagihan Mendekati Jatuh Tempo',
                    'pesan' => "Tagihan {$tagihan->nama_tagihan} untuk {$santri->nama_lengkap} akan jatuh tempo dalam {$hariSebelum} hari ({$tagihan->tanggal_jatuh_tempo->format('d/m/Y')}). Segera lakukan pembayaran.",
                    'tipe' => 'tagihan',
                    'link' => "/wali/tagihan/{$tagihan->id}",
                ]);
            }
        }
    }

    /**
     * Kirim notifikasi tagihan sudah jatuh tempo
     */
    public static function notifikasiJatuhTempo(Tagihan $tagihan): void
    {
        $santri = $tagihan->santri;
        $waliIds = WaliSantri::where('santri_id', $santri->id)->pluck('user_id');

        foreach ($waliIds as $userId) {
            // Cek apakah sudah ada notifikasi jatuh tempo hari ini
            $existing = Notifikasi::where('user_id', $userId)
                ->where('tipe', 'tagihan')
                ->where('judul', 'Tagihan Jatuh Tempo')
                ->where('pesan', 'like', "%{$tagihan->nama_tagihan}%")
                ->whereDate('created_at', today())
                ->exists();

            if (!$existing) {
                Notifikasi::create([
                    'user_id' => $userId,
                    'judul' => 'Tagihan Jatuh Tempo',
                    'pesan' => "Tagihan {$tagihan->nama_tagihan} untuk {$santri->nama_lengkap} sebesar Rp " . number_format($tagihan->total_bayar, 0, ',', '.') . " sudah jatuh tempo. Segera lakukan pembayaran untuk menghindari denda.",
                    'tipe' => 'tagihan',
                    'link' => "/wali/tagihan/{$tagihan->id}",
                ]);
            }
        }
    }

    /**
     * Kirim notifikasi pembayaran berhasil
     */
    public static function notifikasiPembayaranBerhasil($pembayaran): void
    {
        $tagihan = $pembayaran->tagihan;
        $santri = $tagihan->santri;
        $waliIds = WaliSantri::where('santri_id', $santri->id)->pluck('user_id');

        foreach ($waliIds as $userId) {
            Notifikasi::create([
                'user_id' => $userId,
                'judul' => 'Pembayaran Berhasil',
                'pesan' => "Pembayaran {$tagihan->nama_tagihan} untuk {$santri->nama_lengkap} sebesar Rp " . number_format($pembayaran->jumlah_bayar, 0, ',', '.') . " telah berhasil.",
                'tipe' => 'pembayaran',
                'link' => "/wali/pembayaran/{$pembayaran->id}",
            ]);
        }
    }
}
