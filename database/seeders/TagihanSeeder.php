<?php

namespace Database\Seeders;

use App\Models\KategoriTagihan;
use App\Models\Santri;
use App\Models\Tagihan;
use App\Models\User;
use App\Services\NotifikasiService;
use Illuminate\Database\Seeder;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {
        $santriList = Santri::where('status', 'aktif')->get();
        $kategoriSPP = KategoriTagihan::where('nama_kategori', 'SPP Bulanan')->first();
        $admin = User::where('role', 'admin')->first();

        if ($santriList->isEmpty()) {
            $this->command->warn('Tidak ada santri aktif. Jalankan SantriSeeder terlebih dahulu.');
            return;
        }

        if (!$kategoriSPP) {
            $this->command->warn('Kategori SPP Bulanan tidak ditemukan.');
            return;
        }

        $nominal = 500000;
        $tanggalJatuhTempo = '2025-12-08';

        foreach ($santriList as $santri) {
            $tagihan = Tagihan::create([
                'santri_id' => $santri->id,
                'kategori_tagihan_id' => $kategoriSPP->id,
                'nama_tagihan' => 'SPP Bulan Desember 2025',
                'periode' => 'Desember 2025',
                'bulan' => 12,
                'tahun' => 2025,
                'nominal' => $nominal,
                'diskon' => 0,
                'denda' => 0,
                'total_bayar' => $nominal,
                'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                'status' => 'belum_bayar',
                'keterangan' => 'Tagihan SPP bulan Desember 2025',
                'created_by' => $admin?->id,
            ]);

            // Kirim notifikasi ke wali santri
            NotifikasiService::notifikasiTagihanBaru($tagihan);
        }

        $this->command->info('Berhasil membuat tagihan SPP Desember 2025 untuk ' . $santriList->count() . ' santri dengan notifikasi.');
    }
}
