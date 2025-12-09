<?php

namespace App\Console\Commands;

use App\Models\Tagihan;
use App\Services\NotifikasiService;
use Illuminate\Console\Command;

class CekTagihanJatuhTempo extends Command
{
    protected $signature = 'tagihan:cek-jatuh-tempo';
    protected $description = 'Cek tagihan yang mendekati atau sudah jatuh tempo dan kirim notifikasi';

    public function handle(): int
    {
        $this->info('Mengecek tagihan jatuh tempo...');

        // Cek tagihan yang sudah jatuh tempo hari ini
        $tagihanJatuhTempo = Tagihan::where('status', 'belum_bayar')
            ->whereDate('tanggal_jatuh_tempo', '<=', today())
            ->with('santri')
            ->get();

        foreach ($tagihanJatuhTempo as $tagihan) {
            // Update status menjadi jatuh_tempo
            $tagihan->update(['status' => 'jatuh_tempo']);
            
            // Kirim notifikasi
            NotifikasiService::notifikasiJatuhTempo($tagihan);
            $this->line("- Notifikasi jatuh tempo: {$tagihan->nama_tagihan} ({$tagihan->santri->nama_lengkap})");
        }

        // Cek tagihan yang mendekati jatuh tempo (3 hari lagi)
        $tagihanMendekati = Tagihan::where('status', 'belum_bayar')
            ->whereDate('tanggal_jatuh_tempo', '=', today()->addDays(3))
            ->with('santri')
            ->get();

        foreach ($tagihanMendekati as $tagihan) {
            NotifikasiService::notifikasiMendekatiJatuhTempo($tagihan, 3);
            $this->line("- Notifikasi mendekati jatuh tempo: {$tagihan->nama_tagihan} ({$tagihan->santri->nama_lengkap})");
        }

        $this->info("Selesai. {$tagihanJatuhTempo->count()} tagihan jatuh tempo, {$tagihanMendekati->count()} tagihan mendekati jatuh tempo.");

        return Command::SUCCESS;
    }
}
