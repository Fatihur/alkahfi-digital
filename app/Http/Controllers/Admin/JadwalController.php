<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $query = Jadwal::with('createdBy');

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $jadwal = $query->latest()->paginate(10);

        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'waktu_mulai' => ['nullable'],
            'waktu_selesai' => ['nullable'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'jenis' => ['required', 'in:ujian,libur,kegiatan,lainnya'],
            'is_published' => ['boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['created_by'] = auth()->id();

        $jadwal = Jadwal::create($validated);

        LogAktivitas::log('Tambah Jadwal', 'jadwal', "Menambahkan jadwal: {$jadwal->judul}");

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'waktu_mulai' => ['nullable'],
            'waktu_selesai' => ['nullable'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'jenis' => ['required', 'in:ujian,libur,kegiatan,lainnya'],
            'is_published' => ['boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        $jadwal->update($validated);

        LogAktivitas::log('Update Jadwal', 'jadwal', "Mengupdate jadwal: {$jadwal->judul}");

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diupdate.');
    }

    public function destroy(Jadwal $jadwal)
    {
        LogAktivitas::log('Hapus Jadwal', 'jadwal', "Menghapus jadwal: {$jadwal->judul}");

        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
