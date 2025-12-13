<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use App\Models\Santri;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $query = Tagihan::with(['santri']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('santri', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $tagihan = $query->latest()->get();

        return view('bendahara.tagihan.index', compact('tagihan'));
    }

    public function create()
    {
        $santriList = Santri::where('status', 'aktif')->get();
        $kelasList = Kelas::where('is_active', true)->get();

        return view('bendahara.tagihan.create', compact('santriList', 'kelasList'));
    }

    public function store(Request $request)
    {
        $rules = [
            'tipe_tagihan' => ['required', 'in:individual,kelas'],
            'nama_tagihan' => ['required', 'string', 'max:150'],
            'periode' => ['nullable', 'string', 'max:20'],
            'bulan' => ['nullable', 'integer', 'min:1', 'max:12'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2099'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'tanggal_jatuh_tempo' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ];

        if ($request->tipe_tagihan === 'individual') {
            $rules['santri_id'] = ['required', 'exists:santri,id'];
        } elseif ($request->tipe_tagihan === 'kelas') {
            $rules['kelas_id'] = ['required', 'exists:kelas,id'];
        }

        $validated = $request->validate($rules);

        $santriIds = [];

        switch ($request->tipe_tagihan) {
            case 'individual':
                if ($request->filled('santri_id')) {
                    $santriIds = [$request->santri_id];
                }
                break;
            case 'kelas':
                if ($request->filled('kelas_id')) {
                    $santriIds = Santri::where('kelas_id', $request->kelas_id)
                        ->where('status', 'aktif')
                        ->pluck('id')
                        ->toArray();
                }
                break;
        }

        $santriIds = array_filter($santriIds);

        if (empty($santriIds)) {
            return back()->withInput()->with('error', 'Tidak ada santri yang ditemukan. Pastikan memilih santri/kelas yang valid.');
        }

        $count = 0;
        foreach ($santriIds as $santriId) {
            Tagihan::create([
                'santri_id' => $santriId,
                'nama_tagihan' => $request->nama_tagihan,
                'periode' => $request->periode,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'nominal' => $request->nominal,
                'diskon' => 0,
                'denda' => 0,
                'total_bayar' => $request->nominal,
                'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                'status' => 'belum_bayar',
                'keterangan' => $request->keterangan,
                'created_by' => auth()->id(),
            ]);
            $count++;
        }

        LogAktivitas::log('Buat Tagihan', 'tagihan', "Membuat {$count} tagihan: {$request->nama_tagihan}");

        return redirect()->route('bendahara.tagihan.index')
            ->with('success', "Berhasil membuat {$count} tagihan.");
    }

    public function show(Tagihan $tagihan)
    {
        $tagihan->load(['santri', 'pembayaran', 'createdBy']);
        return view('bendahara.tagihan.show', compact('tagihan'));
    }

    public function edit(Tagihan $tagihan)
    {
        return view('bendahara.tagihan.edit', compact('tagihan'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $validated = $request->validate([
            'nama_tagihan' => ['required', 'string', 'max:150'],
            'periode' => ['nullable', 'string', 'max:20'],
            'bulan' => ['nullable', 'integer', 'min:1', 'max:12'],
            'tahun' => ['required', 'integer', 'min:2020', 'max:2099'],
            'nominal' => ['required', 'numeric', 'min:0'],
            'diskon' => ['nullable', 'numeric', 'min:0'],
            'denda' => ['nullable', 'numeric', 'min:0'],
            'tanggal_jatuh_tempo' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $oldData = $tagihan->toArray();

        $validated['diskon'] = $request->diskon ?? 0;
        $validated['denda'] = $request->denda ?? 0;
        $validated['total_bayar'] = $validated['nominal'] - $validated['diskon'] + $validated['denda'];

        $tagihan->update($validated);

        LogAktivitas::log('Update Tagihan', 'tagihan', "Mengupdate tagihan: {$tagihan->nama_tagihan}", $oldData, $tagihan->fresh()->toArray());

        return redirect()->route('bendahara.tagihan.index')
            ->with('success', 'Tagihan berhasil diupdate.');
    }
}
