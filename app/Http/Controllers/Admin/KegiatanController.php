<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kegiatan::with('createdBy');

        if ($request->filled('search')) {
            $query->where('nama_kegiatan', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kegiatan = $query->latest()->paginate(10);

        return view('admin.kegiatan.index', compact('kegiatan'));
    }

    public function create()
    {
        return view('admin.kegiatan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'tanggal_pelaksanaan' => ['required', 'date'],
            'waktu_mulai' => ['nullable'],
            'waktu_selesai' => ['nullable'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:akan_datang,berlangsung,selesai,dibatalkan'],
            'is_published' => ['boolean'],
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kegiatan', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');
        $validated['created_by'] = auth()->id();

        $kegiatan = Kegiatan::create($validated);

        LogAktivitas::log('Tambah Kegiatan', 'kegiatan', "Menambahkan kegiatan: {$kegiatan->nama_kegiatan}");

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'tanggal_pelaksanaan' => ['required', 'date'],
            'waktu_mulai' => ['nullable'],
            'waktu_selesai' => ['nullable'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:akan_datang,berlangsung,selesai,dibatalkan'],
            'is_published' => ['boolean'],
        ]);

        if ($request->hasFile('gambar')) {
            if ($kegiatan->gambar) {
                Storage::disk('public')->delete($kegiatan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('kegiatan', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $kegiatan->update($validated);

        LogAktivitas::log('Update Kegiatan', 'kegiatan', "Mengupdate kegiatan: {$kegiatan->nama_kegiatan}");

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diupdate.');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        if ($kegiatan->gambar) {
            Storage::disk('public')->delete($kegiatan->gambar);
        }

        LogAktivitas::log('Hapus Kegiatan', 'kegiatan', "Menghapus kegiatan: {$kegiatan->nama_kegiatan}");

        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}
