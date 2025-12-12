<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;

use App\Models\Kegiatan;
use App\Models\Pengumuman;

class InformasiController extends Controller
{
    public function pengumuman()
    {
        $pengumuman = Pengumuman::published()
            ->aktif()
            ->latest()
            ->paginate(10);

        return view('wali.informasi.pengumuman', compact('pengumuman'));
    }

    public function showPengumuman(Pengumuman $pengumuman)
    {
        if (!$pengumuman->is_published) {
            abort(404);
        }

        return view('wali.informasi.show-pengumuman', compact('pengumuman'));
    }

    public function kegiatan()
    {
        $kegiatan = Kegiatan::published()
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->paginate(10);

        return view('wali.informasi.kegiatan', compact('kegiatan'));
    }

    public function showKegiatan(Kegiatan $kegiatan)
    {
        if (!$kegiatan->is_published) {
            abort(404);
        }

        return view('wali.informasi.show-kegiatan', compact('kegiatan'));
    }
}
